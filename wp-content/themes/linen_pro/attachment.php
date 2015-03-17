<?php get_header(); ?>
	<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<h1 class="pagetitle"><?php the_title(); ?></h1>
		<div class="entry page clear">
			<a href="<?php echo wp_get_attachment_url( $post->ID ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
				<?php
					if ( wp_attachment_is_image ( $post->ID ) ) {
						$img_src = wp_get_attachment_image_src( $post->ID, 'large' );
						$alt_text = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
				?>
						<img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( $alt_text ); ?>">
				<?php
					} else {
						echo basename( $post->guid );
					}
				?>
			</a>
			<?php if ( ! empty( $post->post_excerpt ) ) : ?>
			    <div class="entry-caption">
			        <?php the_excerpt(); ?>
			    </div>
			<?php endif; ?>
			<div class="description">
				<?php the_content(); ?>
			</div>
		</div><!--end entry-->
		<div class="navigation clear">
			<div class="alignleft"><?php previous_image_link( 0, __( '&larr; Previous image', 'linen' ) ); ?></div>
			<div class="alignright"><?php next_image_link( 0, __( 'Next image &rarr;', 'linen' ) ); ?></div>
		</div>
		<div class="navigation clear">
			<a href="<?php echo get_permalink( $post->post_parent ); ?>"><?php _e( 'Return to gallery', 'linen' ); ?></a>
		</div>
	<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
	<?php else : ?>
	<?php endif; ?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>