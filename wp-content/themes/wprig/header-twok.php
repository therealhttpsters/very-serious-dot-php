<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package veryserious
 */

 // here is a list of scripts to be unloaded
 $dscript_array = [
//	'admin-bar',
//	'veryserious-navigation',
//	'veryserious-skip-link-focus-fix',
//	'comment-reply',
	'veryserious-lazy-load-images',
//	'wp-embed'
];

// here is a list of scripts to be unloaded
$dstyle_array = [
//	'veryserious-content',
//	'admin-bar',
//	'wp-block-library',
//	'veryserious-fonts',
//	'veryserious-base-style',
//	'current-template-style'
];

// passing the above lists to WP to unload items
add_action( 
		'wp_enqueue_scripts',
		new DeQueueQueue( 
			$dstyle_array, 
			$dstyle_array 
		), 10, 1 );

function EnQueueQueue()  {

		// Add new CSS, cache busters to go!
		$app = '/css/2004.css'; // Local path in theme
			$appURI = get_stylesheet_directory_uri() . $app;
			$appPath = get_template_directory() . $app;
			wp_enqueue_style('2004', $appURI , array(), 
			filemtime( $appPath ) ); 
		// Note: HTML1 spec predates CSS, so there's no need for a stylesheet.
			
		// Add new JS, cache busters to go!
		// jQuery stuff is required this time around
		wp_enqueue_script('jQuery-1.12.4', 
		'https://code.jquery.com/jquery-1.12.4.js');
		wp_enqueue_script('jQueryUI-1.12.1', 
		'https://code.jquery.com/ui/1.12.1/jquery-ui.js');
		
		$app = '/js/2004.js'; // Local path in theme
			$appURI = get_stylesheet_directory_uri() . $app;
			$appPath = get_template_directory() . $app;
		
			wp_enqueue_script('2004', $appURI, array(), 
				filemtime( $appPath ), 'jquery');
}
add_action( 'wp_enqueue_scripts', 'EnQueueQueue' );

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php if ( ! veryserious_is_amp() ) : ?>
		<script>document.documentElement.classList.remove("no-js");</script>
	<?php endif; ?>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="progressbar"><div class="progress-label">Loading...</div></div>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'veryserious' ); ?></a>
		<header id="masthead" class="site-header">
			<?php if ( has_header_image() ) : ?>
				<figure class="header-image">
					<?php the_header_image_tag(); ?>
				</figure>
			<?php endif; ?>
			<div class="site-branding" id="draggable">
				<?php the_custom_logo(); ?>
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif; ?>

				<?php $veryserious_description = get_bloginfo( 'description', 'display' ); ?>
				<?php if ( $veryserious_description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $veryserious_description; /* WPCS: xss ok. */ ?></p>
				<?php endif; ?>
				
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Main menu', 'veryserious' ); ?>"
				<?php if ( veryserious_is_amp() ) : ?>
					[class]=" siteNavigationMenu.expanded ? 'main-navigation toggled-on' : 'main-navigation' "
				<?php endif; ?>
			
				<?php if ( veryserious_is_amp() ) : ?>
					<amp-state id="siteNavigationMenu">
						<script type="application/json">
							{
								"expanded": false
							}
						</script>
					</amp-state>
				<?php endif; ?>

				<button class="menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'veryserious' ); ?>" aria-controls="primary-menu" aria-expanded="false"
					<?php if ( veryserious_is_amp() ) : ?>
						on="tap:AMP.setState( { siteNavigationMenu: { expanded: ! siteNavigationMenu.expanded } } )"
						[aria-expanded]="siteNavigationMenu.expanded ? 'true' : 'false'"
					<?php endif; ?>
				
					<?php esc_html_e( 'Menu', 'veryserious' ); ?>
				</button>

				<div class="primary-menu-container">
					<?php

					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => 'ul',
						)
					);

					?>
				</div>
			</nav><!-- #site-navigation -->
		</header><!-- #masthead -->

<?php
/*	$page_id = 1;
	$page_object = get_page( $page_id );
	echo '<script>console.log("' . 
		$page_object->post_content . '");</script>' ; ?>
*/
?>