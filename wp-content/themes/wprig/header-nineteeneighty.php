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
	'admin-bar',
	'veryserious-navigation',
	'veryserious-skip-link-focus-fix',
	'comment-reply',
	'veryserious-lazy-load-images',
	'wp-embed'
];

// here is a list of scripts to be unloaded
$dstyle_array = [
	'veryserious-content',
	'admin-bar',
	'wp-block-library',
	'veryserious-fonts',
	'veryserious-base-style',
	'current-template-style'
];

// passing the above lists to WP to unload items
add_action( 
		'wp_enqueue_scripts',
		new DeQueueQueue( 
			$dstyle_array, 
			$dstyle_array 
		),
		10, 
		1 );

function EnQueueQueue()  {


		// Add new CSS, cache busters to go!
		/* $app = '/css/1980.css'; // Local path in theme
			$appURI = get_stylesheet_directory_uri() . $app;
			$appPath = get_template_directory() . $app;
			wp_enqueue_style('app', $appURI , array(), 
			filemtime( $appPath ) ); */
		// Note: HTML1 spec predates CSS, so there's no need for a stylesheet.
			
		// Add new JS, cache busters to go!
		/* $app = '/javascript/app.min.js'; // Local path in theme
			$appURI = get_stylesheet_directory_uri() . $app;
			$appPath = get_template_directory() . $app;
		
			wp_enqueue_script('foundation', $appURI, array(), 
				filemtime( $appPath ), false);
		}*/
}
add_action( 'wp_enqueue_scripts', 'EnQueueQueue' );
	

?>
<!doctype html>
<HTML <?php language_attributes(); ?> class="no-js">
<HEAD>

	<?php wp_head(); ?>
</HEAD>
<BODY <?php body_class(); ?>>

<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_id'        => 'primary-menu',
			'container'      => 'ul',
		)
	);
?>
