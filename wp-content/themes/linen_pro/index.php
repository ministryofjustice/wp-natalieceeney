<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'clear' ); ?>>
			<div class="post-date-box <?php if ( ! has_post_thumbnail() ) echo 'no-thumb'; ?>">
				<div class="post-date">
					<p><?php the_time( __( 'M j', 'linen' ) ); ?></p>
				</div>
				<?php if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'index-thumb' );
				} ?>
				<div class="post-comments">
					<?php comments_popup_link( '',  __( '1 Question', 'linen' ), sprintf( __( '%s Questions', 'linen' ), get_comments_number ()/2), '', ''); ?>
				</div>
			</div>
			<div class="entry">
				<h2 class="title">
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr( sprintf( __( 'Permanent Link to %s', 'linen' ), the_title_attribute( 'echo=false' ) ) ); ?>"><?php the_title(); ?></a>
				</h2>
				<?php
					if ( $post->post_excerpt ) {
						echo $linen->custom_excerpt();
					} else {
						the_content( __( 'Read more', 'linen' ) );
					}
				?>
				<?php edit_post_link( __( 'Edit this', 'linen' ), '<p>', '</p>' ); ?>
			</div><!--end entry-->
		</div><!--end post-->
	<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
	<div class="navigation index">
		<div class="alignleft"><?php next_posts_link( __( '&larr; Older Entries', 'linen' ) ); ?></div>
		<div class="alignright"><?php previous_posts_link( __( 'Newer Entries &rarr;', 'linen' ) ); ?></div>
	</div><!--end navigation-->
<?php endif; ?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
