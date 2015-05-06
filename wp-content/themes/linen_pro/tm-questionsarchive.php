<?php
/*
Template Name: Questions archive
*/
?>
<?php get_header(); ?>

	<?php if (have_posts()) : ?>
		<h1 class="pagetitle">Questions archive</h1>
		<div class="entry">

		</div><!--end-entry-->
		<div class="entries">
			<ul>
				<?php while (have_posts()) : the_post(); ?>

				<?php

				// WP_Comment_Query arguments
				$args = array (
					'author__in'   => array('Anju Sinha'),

				);

				// The Comment Query
				$comment_query = new WP_Comment_Query;
				$comments = $comment_query->query( $args );

				// Comment Loop
				if ( $comments ) {
					foreach ( $comments as $comment ) { ?>
						<li><?php echo $comment->comment_author; ?> said: <a href="<?php echo get_comment_link( $comment->comment_ID ); ?>"> <?php echo get_comment_excerpt( $comment->comment_ID );  ?>.</a></li>
					<?php }
				} else {
					echo 'No comments found.';
				}
				?>
				
				<?php endwhile; ?>

				<?php endif; ?>

			</ul>
		</div><!--end entries-->

</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>