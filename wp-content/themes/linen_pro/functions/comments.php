<?php
	function linen_custom_comment ( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
		$answer = "";
	?>

	<?php if( !empty( $comment->comment_parent ) ): $answer = "answer"; endif;?>
	<li <?php comment_class($answer); ?> id="comment-<?php comment_ID(); ?>" >
		<div class="c-grav"><?php echo get_avatar( $comment, '62' ); ?></div>
		<div class="c-body">
			<?php if( empty( $comment->comment_parent ) ): ?>
			<div class="c-head">
				<?php comment_author_link(); ?><br><span class="comment-date"><?php comment_date('j F Y'); ?></span>
			</div>
			<?php else: ?>
			<div class="c-head">
			<?php  
       // $username = $_POST['username'];
       if ( username_exists( 'vcj63z' ) )
           echo "Natalie's response";
       else
           echo comment_author_link();
		?>
				<br><span class="comment-date"><?php comment_date('j F Y'); ?></span>
			</div>
			<?php endif; ?>
			<?php if ($comment->comment_approved == '0' ) : ?>
				<p><?php _e( '<em><strong>Please Note:</strong> Your comment is awaiting moderation.</em>', 'linen' ); ?></p>
			<?php endif; ?>
			<?php comment_text(); ?>
			<?php comment_type(( '' ),( 'Trackback' ),( 'Pingback' )); ?>
						<div class="reply">
				<?php echo comment_reply_link(array( 'depth' => $depth, 'max_depth' => $args['max_depth']));	 ?>
			</div>
		</div><!--end c-body-->
		<?php
}

// Template for pingbacks/trackbacks
function linen_list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
	<?php
}
