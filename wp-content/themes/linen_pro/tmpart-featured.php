<?php global $linen; ?>
<div id="featured" class="clear">
	<div class="container">
		<div id="slides">
			<div class="slides_container">
				<?php query_posts( array( 'post__in' => get_option( 'sticky_posts' ), 'posts_per_page' => -1 ) ); ?>
				<?php $count_1 = 0; ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); $count_1++; ?>
					<div id="slide-<?php echo esc_attr( $count_1 ); ?>" class="slide<?php echo ( ! $linen->use_javascript_slider() || $count_1 == 1 ) ? ' show-slide' : ''; ?>">
						<?php if ( has_post_thumbnail() ) :
							the_post_thumbnail( 'featured', array( 'class' => 'feature-photo' ));
						endif; ?>
						<div class="slide-content">
							<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr( sprintf( __( 'Permanent Link to %s', 'linen' ), the_title_attribute( 'echo=false' ) ) ); ?>"><?php the_title(); ?></a></h2>
							<?php
								if ($post->post_excerpt) {
									echo $linen->custom_excerpt();
								} else {
									echo $linen->custom_content( 35 );
								}
							?>
						</div>
					</div>
				<?php endwhile; endif; ?>
				<?php wp_reset_query(); ?>
			</div>
			<?php if ( $linen->use_javascript_slider() ) : ?>
				<a href="#" class="prev"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/featured-arrow-prev.png' ); ?>" width="20" height="40" alt="Arrow for previous featured post"></a>
				<a href="#" class="next"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/featured-arrow-next.png' ); ?>" width="20" height="40" alt="Arrow for next featured post"></a>
			<?php endif; ?>
		</div>
	</div>
</div><!--end featured-->