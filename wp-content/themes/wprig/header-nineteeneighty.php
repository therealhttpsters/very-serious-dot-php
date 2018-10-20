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

function dq_maker($dscript_array, $dstyle_array) {
	//var_dump($dscript_array);
	//die;
	return function () {
		foreach ( $dscript_array as $script_item ) {
			wp_dequeue_script ( $script_item );
		}

		foreach ( $dstyle_array as $style_item ) {
			wp_dequeue_style ( $style_item );
		}		
	};

}

$dscript_array = [
	'admin-bar',
	'veryserious-navigation',
	'veryserious-skip-link-focus-fix',
	'comment-reply',
	'veryserious-lazy-load-images',
	'wp-embed'
];

$dstyle_array = [
	'veryserious-content',
	'admin-bar',
	'wp-block-library',
	'veryserious-fonts',
	'veryserious-base-style',
	'current-template-style'
];



add_action( 'wp_enqueue_scripts', dq_maker($dstyle_array, $dstyle_array), 10, 1 );

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
