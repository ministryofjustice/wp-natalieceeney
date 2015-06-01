<?php if ( post_password_required() ) : ?>
	<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view questions and answers.', 'linen' ); ?></p>
	<?php
	return;
endif; ?>
<div id="comments">
<?php if ( have_comments() ) : ?>
	<div class="comment-number clear">
		<span><?php comments_number( __( 'No Comments or views', 'linen' ), __( 'One Comment or view', 'linen' ), sprintf( __( '%s Comments and views', 'linen' ), get_comments_number ()/2)); ?></span>
		<?php if ( comments_open() ) : ?>
			<a id="leavecomment" href="#respond" title="<?php esc_attr_e( 'Post a comment or view', 'linen' ); ?>"> <?php _e( 'Post a comment or view', 'linen' ); ?></a>
		<?php endif; ?>
	</div><!--end comment-number-->
	<ol class="commentlist">
		<?php wp_list_comments( 'type=comment&callback=linen_custom_comment' ); ?>
	</ol>

	<div class="navigation clear">
		<div class="alignleft"><?php next_comments_link(__( '&laquo; Older', 'linen' )); ?></div>
		<div class="alignright"><?php previous_comments_link(__( 'Newer &raquo;', 'linen' )); ?></div>
	</div>
	<?php if ( ! empty($comments_by_type['pings']) ) : ?>
		<h3 class="pinghead"><?php _e( 'Trackbacks &amp; Pingbacks', 'linen' ); ?></h3>
		<ol class="pinglist">
			<?php wp_list_comments( 'type=pings&callback=linen_list_pings' ); ?>
		</ol>

		<div class="navigation clear">
			<div class="alignleft"><?php next_comments_link(__( '&laquo; Older Pingbacks', 'linen' )); ?></div>
			<div class="alignright"><?php previous_comments_link(__( 'Newer Pingbacks &raquo;', 'linen' )); ?></div>
		</div>
	<?php endif; ?>
<?php elseif ( comments_open() ) : // this is displayed if there are no comments so far ?>
	<!-- If comments are open, but there are no comments. -->
	<div class="comment-number">
		<span><?php _e( 'No Comments or views yet', 'linen' ); ?></span>
	</div>
<?php endif; ?>
<?php if ( ! comments_open() && ! is_page() ) : // displayed when comments are closed, regardless of # of comments ?>
	<p class="note"><?php _e( 'Comments are closed.', 'linen' ); ?></p>
<?php endif; ?>
</div><!--end comments-->

<?php
$req = get_option( 'require_name_email' );
$field = '<p><label for="%1$s" class="comment-field">%2$s</label><input class="text-input" type="text" name="%1$s" id="%1$s" value="%3$s" size="22" tabindex="%4$d" /></p>';
comment_form( array(
	'comment_field' => '<fieldset><label for="comment" class="comment-field"><small>' . _x( 'Comment', 'noun', 'linen' ) . '</small></label><textarea id="comment" name="comment" cols="50" rows="10" aria-required="true" tabindex="4"></textarea></fieldset>',
	'comment_notes_before' => '',
	'comment_notes_after' => '',
	'fields' => array(
		'author' => sprintf(
			$field,
			'author',
			(
				$req ?
				__( 'Name <span>(required)</span>:', 'linen' ) :
				__( 'Name (required):', 'linen' )
			),
			'',
			1
		),
		'email' => sprintf(
			'<p><label for="job" class="comment-field">Job Title (required):</label><input class="text-input" type="text" name="job" id="job" value="" size="22" tabindex="1"></p>',
			'job',
			(
				$req ?
				__( 'Job Title <span>(required)</span>:', 'linen' ) :
				__( 'Job Title:', 'linen' )
			),
			'',
			2
		),
//		'url' => sprintf(
//			$field,
//			'url',
//			__( 'Website:', 'linen' ),
//			esc_attr( $comment_author_url ),
//			3
//		),
	),
	'label_submit' => __( 'Submit', 'linen' ),
	'logged_in_as' => '<p class="com-logged-in">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>', 'linen' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
	'title_reply' => __( 'Post a comment or view', 'linen' ),
	'title_reply_to' => __( 'Leave a answer to %s', 'linen' ),
) );
