<?php global $linen; ?>
<!DOCTYPE html>
<html <?php language_attributes( 'html' ) ?>>
<head>
	<?php if ( is_front_page() ) : ?>
		<title><?php bloginfo( 'name' ); ?></title>
	<?php elseif ( is_404() ) : ?>
		<title><?php _e( 'Page Not Found |', 'linen' ); ?> | <?php bloginfo( 'name' ); ?></title>
	<?php elseif ( is_search() ) : ?>
		<title><?php printf(__ ("Search results for '%s'", "linen"), get_search_query()); ?> | <?php bloginfo( 'name' ); ?></title>
	<?php else : ?>
		<title><?php wp_title($sep = '' ); ?> | <?php bloginfo( 'name' );?></title>
	<?php endif; ?>

	<!-- Basic Meta Data -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="copyright" content="<?php 
		echo esc_attr( sprintf(
			__( 'Design is copyright %1$s The Theme Foundry', 'linen' ),
			date( 'Y' )
		) );
	?>" />

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" />

	<!-- WordPress -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
    
    <link rel="stylesheet" type="text/css" href="<?php echo home_url(); ?>/wp-content/themes/linen_pro/stylesheets/one.css">
    <link rel="stylesheet" type="text/css" href="<?php echo home_url(); ?>/wp-content/themes/linen_pro/stylesheets/two.css">
	<link href='http://fonts.googleapis.com/css?family=Cabin:400,700' rel='stylesheet' type='text/css'>
	
</head>
<body <?php body_class(); ?>>
	<div class="skip-content"><a href="#content"><?php _e( 'Skip to content', 'linen' ); ?></a></div>
	<div id="wrapper" class="clear">
		<div id="header" class="clear">
			<?php if ($linen->logoState() == 'true' ) : ?>
				<?php $upload_dir = wp_upload_dir(); ?>
				<div id="title">
					<a href="<?php echo home_url( '/' ); ?>">
						<img src="<?php echo $linen->logoName(); ?>" alt="<?php if ($linen->logoAlt() !== '' ) echo $linen->logoAlt(); else echo bloginfo( 'name' ); ?>" /><span class="blogname">Natalie's blog</span>
					</a>
				</div>
				<?php if ($linen->logoTagline() == 'true' ) : ?>
					<div id="description">
						<h2><?php bloginfo( 'description' ); ?></h2>
					</div><!--end description-->
				<?php endif; ?>
			<?php else : ?>
				<?php if (is_home()) echo( '<h1 id="title">' ); else echo( '<div id="title">' );?><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a><?php if (is_home()) echo( '</h1>' ); else echo( '</div>' );?>
					<div id="description">
						<h2><?php bloginfo( 'description' ); ?></h2>
					</div><!--end description-->
			<?php endif; ?>
			<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'nav-1',
						'container_id'    => 'navigation',
						'container_class' => 'clear',
						'menu_class'      => 'nav',
						'fallback_cb'     => array( &$linen, 'main_menu_fallback')
						)
					);
			?>
		</div><!--end header-->
		<?php if ( (is_front_page() || $wp_query->is_posts_page) && !is_paged() && $linen->use_featured_header() ) { ?>
			<?php get_template_part( 'tmpart-featured' ); ?>
		<?php } ?>
		<?php if (is_page_template( 'tm-left-sidebar.php' )) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		
	<div id="featured" class="clear">
		<div class="container">
			<div id="slides">
				<div class="slides_container">
					<div id="slide-1" class="slide show-slide">
						<!--<img scale="0" src="/wp-content/themes/linen_pro/images/ursula-banner.jpg" height="353" width="652">-->
						<div class="slide-content">
							<!--<h2>Get to know a bit more about me, what I'm up to and what makes me tick...</h2>-->
							<p>My blog about HMCTS... Please share your views.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		
		<div id="content" <?php if ( ( is_page_template( 'tm-no-sidebar.php' ) ) || ( $linen->sidebarDisable() == 'true' ) ) echo ( 'class="no-sidebar"' ); ?>>