<?php global $linen; ?>
<div class="subscribe clear">
	<?php if ( $linen->followDisable() != 'true' ) { ?>
		<ul>
			<?php if ( $linen->flickrToggle() == 'true' ) { ?>
				<li>
					<a href="<?php echo esc_url( $linen->flickr() ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/flw-flickr.png' ); ?>" alt="<?php esc_attr_e( 'Flickr', 'linen' ); ?>" title="<?php esc_attr_e( 'Flickr', 'linen' ); ?>"/></a>
				</li>
			<?php } ?>
			<?php if ( $linen->googlePlusToggle() == 'true' ) { ?>
				<li>
					<a href="<?php echo esc_url( $linen->googlePlus() ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/flw-google-plus.png' ); ?>" alt="<?php esc_attr_e( 'Google+', 'linen' ); ?>"title="<?php esc_attr_e( 'Google+', 'linen' ); ?>"/></a>
				</li>
			<?php } ?>
			<?php if ( $linen->facebookToggle() == 'true' ) { ?>
				<li>
					<a href="<?php echo esc_url( $linen->facebook() ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/flw-facebook.png' ); ?>" alt="<?php esc_attr_e( 'Facebook', 'linen' ); ?>" title="<?php esc_attr_e( 'Facebook', 'linen' ); ?>"/></a>
				</li>
			<?php } ?>
			<?php if ( $linen->twitterToggle() == 'true' ) { ?>
				<li>
					<a href="http://twitter.com/<?php esc_attr_e( $linen->twitter() ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/flw-twitter.png' ); ?>" alt="<?php esc_attr_e( 'Twitter', 'linen' ); ?>" title="<?php esc_attr_e( 'Twitter', 'linen' ); ?>"/></a>
				</li>
			<?php } ?>
			<li>
				<a href="<?php bloginfo( 'rss2_url' ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/flw-rss.png' ); ?>" alt="<?php esc_attr_e( 'RSS Feed', 'linen' ); ?>" title="<?php esc_attr_e( 'RSS', 'linen' ); ?>"/></a>
			</li>
		</ul>
	<?php } ?>
</div>