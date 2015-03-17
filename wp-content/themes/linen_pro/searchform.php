<form method="get" id="search-form" action="<?php echo home_url( '/' ); ?>/">
	<div>
		<label for="s"><?php _e( 'Search', 'linen' ); ?></label>
		<input type="text" value="" name="s" id="s"/>
		<input type="submit" id="search-btn" value="<?php esc_attr_e( 'Search', 'linen' ); ?>" />
	</div>
</form>