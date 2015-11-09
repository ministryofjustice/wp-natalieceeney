<?php

namespace LikeComments;

use stdClass;
use Exception;
use wpdb;
use DateTime;
use DateTimeZone;

class Plugin {
    /**
     * Plugin version number
     *
     * @var string
     */
    public $version = '0.0.1';

    public $table_name = null;

    /**
     * Path to the plugin file
     *
     * @var string
     */
    public $pluginFile = null;

    /**
     * Class constructor
     *
     * @param string $pluginFile
     */
    public function __construct($pluginFile) {
        $this->table_name = $this->wpdb()->prefix . 'comment_likes';
        $this->pluginFile = $pluginFile;

        // Hook in to filters and actions
        add_filter('comment_output',                array($this, 'comment_output'), 10, 4); // Filter comment HTML
        add_filter('comments_array',                array($this, 'reorder_comments'));      // Sort comments by popularity
        add_action('wp_enqueue_scripts',            array($this, 'enqueue_assets'));        // Add our CSS & JS to the page
        add_action('wp_ajax_like_comment',          array($this, 'ajax_like_comment'));     // AJAX endpoint
        add_action('wp_ajax_nopriv_like_comment',   array($this, 'ajax_like_comment'));     // AJAX endpoint (for unauthenticated users)

        // Register activation hooks
        register_activation_hook($this->pluginFile, array($this, 'install_db'));            // Create database tables
        register_uninstall_hook($this->pluginFile,  array($this, 'uninstall_db'));          // Remove database tables
    }

    /**
     * Get the global $wpdb object.
     *
     * @return wpdb
     */
    public function wpdb() {
        global $wpdb;
        return $wpdb;
    }

    /**
     * Sort comments to appear in order of popularity
     *
     * This method looks complicated (it is, unfortunately) so I'll explain:
     *  – Top-level comments will be sorted by number of likes, then by date posted (DESC)
     *  – Child comments will be sorted by date posted (ASC) regardless of like count
     *
     * The date-based sorting of child comments allows for a proper discussion thread, but by sorting
     * top-level comments by likes first we get a view of the most popular comments.
     *
     * Settings > Discussion *must be set* with:
     * "Comments should be displayed with the NEWER comments at the top of each page"
     *
     * @param $comments
     * @return array
     */
    public function reorder_comments($comments) {
        $likes = array();
        $dates = array();
        $parents = array();

        $childI = 1;

        foreach ($comments as $comment) {
            $dateTime = new DateTime($comment->comment_date_gmt, new DateTimeZone('GMT'));
            $dates[] = $dateTime;

            if ($comment->comment_parent != 0) {
                $likes[] = 0;
                $parents[] = $childI;
                $childI++;
            } else {
                $objComment = $this->newComment($comment->comment_ID);
                $likes[] = $objComment->getLikeCount();
                $parents[] = 0;
            }
        }

        array_multisort($parents, SORT_DESC, $likes, SORT_DESC, $dates, SORT_DESC, $comments);

        $comments = array_reverse($comments);

        return $comments;
    }

    /**
     * Add like button to comment HTML output.
     * Filter: comment_output
     *
     * @param string $output
     * @param stdClass $comment
     * @param array $args
     * @param int $depth
     * @return string
     */
    public function comment_output($output, $comment, $args, $depth) {
        $objComment = $this->newComment($comment->comment_ID);
        $likeButton = $this->like_button_html($objComment);
        $likeCount = $this->like_count_html($objComment);
        $output = preg_replace('/<div class="reply">([\S\s]*?)<\/div>/i', '<div class="reply">' . $likeButton . ' $1 ' . $likeCount . '</div>', $output);
        return $output;
    }

    /**
     * Get the HTML for the like button.
     *
     * @param Comment $comment
     * @return string
     */
    public function like_button_html(Comment $comment) {
        $html = sprintf('<a href="#" data-comment-id="%1$d" class="lc_like_button">%2$s</a>', $comment->object->comment_ID, 'Like');

        if ($comment->hasAlreadyBeenLiked()) {
            $html = '<span class="lc_like_button lc_like_button--liked">Liked</span>';
        }

        $html = apply_filters('LikeComments/like_button_html', $html, $comment);
        return $html;
    }

    /**
     * Get the HTML for the like count.
     *
     * @param Comment $comment
     * @return string
     */
    public function like_count_html(Comment $comment) {
        $likeCount = $comment->getLikeCount();

        if ($likeCount < 1) {
            // No likes here – output nothing.
            return '<span class="lc_like_count lc_like_count--empty">&nbsp;</span>';
        }

        $imgUrl = plugins_url('/img/thumbsup.png', $this->pluginFile);
        $likeCount = $comment->getLikeCount();
        $html = '&ndash; <img src="' . $imgUrl . '" width="18" height="18" alt="Thumbs up icon" /> ';
        $html .= $likeCount;

        $title = $likeCount . ' ' . _n('person', 'people', $likeCount) . ' like this comment';
        $html = '<span class="lc_like_count" title="' . $title . '">' . $html . '</span>';
        $html = apply_filters('LikeComments/like_count_html', $html, $comment);
        return $html;
    }

    /**
     * Enqueue CSS and JS assets on the page.
     * Filter: wp_enqueue_scripts
     *
     * @return void
     */
    public function enqueue_assets() {
        wp_enqueue_script('like_comments', plugins_url('/js/scripts.js', $this->pluginFile), array('jquery'), $this->version, true);

        $jsConfig = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        );
        wp_localize_script('like_comments', 'LikeComments', $jsConfig);
    }

    /**
     * Create a new comment object for the supplied comment ID.
     *
     * @param $commentID
     * @return Comment
     */
    public function newComment($commentID) {
        return new Comment($commentID, $this, $this->wpdb());
    }

    /**
     * Ajax method called when user clicks to like a comment.
     */
    public function ajax_like_comment() {
        if (!isset($_POST['commentID']) || !is_numeric($_POST['commentID'])) {
            wp_send_json_error();
            wp_die();
        }

        try {
            $comment = $this->newComment($_POST['commentID']);
            $comment->like();
            wp_send_json_success(array(
                'likeButtonHtml' => $this->like_button_html($comment),
                'likeCountHtml' => $this->like_count_html($comment),
            ));
        } catch (Exception $e) {
            wp_send_json_error(array(
                'message' => $e->getMessage(),
            ));
        }

        wp_die();
    }

    /**
     * Get the current user's identity.
     * If they don't have one yet, one will be created when $force = true
     * False is returned if no identity exists and $force = false
     *
     * @param bool|false $force Generate an identity when one does not exist
     * @return false|string
     */
    public function get_user_identity($force = false) {
        if ($this->user_has_identity()) {
            return $_COOKIE['like_comments_user'];
        }

        if ($force) {
            $this->generate_user_identity();
            return $_COOKIE['like_comments_user'];
        }

        return false;
    }

    /**
     * Check if the current user has an identity.
     *
     * @return bool
     */
    public function user_has_identity() {
        return isset($_COOKIE['like_comments_user']);
    }

    /**
     * Generate a new identity for the user, and
     * assign it as a cookie.
     */
    public function generate_user_identity() {
        $identity = uniqid('', true);
        setcookie('like_comments_user', $identity, strtotime('+30 days'), '/');
        $_COOKIE['like_comments_user'] = $identity;
    }

    /**
     * Create a custom database table to store comment likes.
     */
    public function install_db() {
        $charset_collate = $this->wpdb()->get_charset_collate();

        $sql = "CREATE TABLE {$this->table_name} (
                  user_ID char(23) NOT NULL,
                  comment_ID bigint(20) NOT NULL,
                  UNIQUE KEY user_comment (user_ID, comment_ID),
                  KEY comment_ID (comment_ID)
                ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Remove traces of this plugin from the database.
     */
    public function uninstall_db() {
        $this->oldWpdb->query("DROP TABLE IF EXISTS {$this->table_name}");

        $metaTable = $this->wpdb()->prefix . 'commentmeta';
        $this->oldWpdb->query("DELETE FROM $metaTable WHERE meta_key = 'comment_likes'");
    }
}