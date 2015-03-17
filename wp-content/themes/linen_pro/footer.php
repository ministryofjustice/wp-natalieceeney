<?php global $linen; ?>
</div><!--end wrapper-->
	<?php if ( $linen->footerDisable() != 'true' ) { ?>
		<div id="footer" class="clear">
			<div id="footer-1" class="footer-column">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_1') ) : ?>
					<!-- <h2 class="widgettitle"><?php _e( 'About Us' , 'linen' ); ?></h2> -->
					
				<?php endif; ?>
			</div>
			<div id="footer-2" class="footer-column">
				<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'footer_2' ) ) : ?>
					<!-- <h2 class="widgettitle"><?php _e( 'Pages' , 'linen' ); ?></h2>
					<ul>
						<?php wp_list_pages( 'depth=1&title_li=' ); ?>
					</ul> -->
				<?php endif; ?>
			</div>
			<div id="footer-3" class="footer-column">
				<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'footer_3' ) ) : ?>
					<!-- <h2 class="widgettitle"><?php _e( 'Categories', 'linen' ); ?></h2>
					<ul>
						<?php wp_list_categories( 'depth=1&title_li=' ); ?>
					</ul> -->
				<?php endif; ?>
			</div>
			<div id="footer-4" class="footer-column">
				<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'footer_4' ) ) : ?>
					<!-- <h2 class="widgettitle"><?php _e( 'Search', 'linen' ); ?></h2> 
					<?php get_search_form(); ?>-->
				<?php endif; ?>
			</div>
		</div>
	<?php } ?>
	<div id="copyright" class="wrapper">
		<p>
			<?php
//				printf(
//					__( '<a href="%1$s">Linen Theme</a> by <a href="%2$s">The Theme Foundry</a>', 'linen' ),
//					'http://thethemefoundry.com/linen/',
//					'http://thethemefoundry.com/'
//				);
//			?>
		</p>
		<p>
			<?php printf(
				__( 'Ministry of Justice Copyright &copy; %1$s %2$s. All rights reserved.', 'linen' ),
				date( 'Y' ),
				$linen->copyrightName()
			); ?>
		</p>
	</div><!--end copyright-->
<?php wp_footer(); ?>
<script type="text/javascript" src="/wp-content/themes/linen_pro/javascripts/analytics.js"></script>
</body>
</html>