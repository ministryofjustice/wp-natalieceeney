<?php

namespace LikeComments;

use Exception;
use wpdb;

class Comment {
    /**
     * Holds the WordPress comment object.
     *
     * @var array|null|object
     */
    public $object = null;

    /**
     * @var Plugin
     */
    public $plugin = null;

    /**
     * @var wpdb
     */
    public $wpdb = null;

    /**
     * Class constructor
     *
     * @param int $commentID
     * @param Plugin $plugin
     * @param wpdb $wpdb
     * @throws Exception
     */
    public function __construct($commentID, $plugin, $wpdb) {
        $comment = get_comment($commentID, 'OBJECT');
        if (is_null($comment)) {
            throw new Exception('Comment not found');
        } else {
            $this->object = $comment;
        }
        $this->plugin = $plugin;
        $this->wpdb = $wpdb;
    }

    public function hasAlreadyBeenLiked() {
        $user_ID = $this->plugin->get_user_identity();

        if (!$user_ID) {
            // User does not have an identity, so they have not liked the comment.
            return false;
        }

        $table = $this->plugin->table_name;
        $comment_ID = $this->object->comment_ID;

        $sql = $this->wpdb->prepare("SELECT COUNT(*) FROM $table WHERE user_ID = %s AND comment_ID = %d", $user_ID, $comment_ID);
        $liked = $this->wpdb->get_var($sql);

        return ( intval($liked) > 0 );
    }

    public function like() {
        if ($this->hasAlreadyBeenLiked()) {
            return false;
        }

        $user_ID = $this->plugin->get_user_identity(true);
        $table = $this->plugin->table_name;
        $comment_ID = $this->object->comment_ID;

        $this->wpdb->insert($table, array(
            'user_ID' => $user_ID,
            'comment_ID' => $comment_ID,
        ), array(
            '%s',
            '%d',
        ));

        $this->updateLikeCount();
    }

    public function updateLikeCount() {
        $table = $this->plugin->table_name;
        $comment_ID = $this->object->comment_ID;

        $countSql = $this->wpdb->prepare("SELECT COUNT(*) FROM $table WHERE comment_ID = %d", $comment_ID);
        $count = $this->wpdb->get_var($countSql);

        update_comment_meta($comment_ID, 'comment_likes', $count);
    }

    public function getLikeCount() {
        $comment_ID = $this->object->comment_ID;
        return intval(get_comment_meta($comment_ID, 'comment_likes', true));
    }
}