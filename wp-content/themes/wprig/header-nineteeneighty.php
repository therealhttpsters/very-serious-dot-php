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

function my_enqueue_stuff() {

	wp_dequeue_script ( 'admin-bar' );
	wp_dequeue_script ( 'veryserious-navigation ' );
	wp_dequeue_script ( 'veryserious-skip-link-focus-fix ' );
	wp_dequeue_script ( 'comment-reply ' );
	wp_dequeue_script ( 'veryserious-lazy-load-images ' );

	wp_dequeue_style ( 'veryserious-content' );
	wp_dequeue_style ( 'admin-bar' );
	wp_dequeue_style ( 'wp-block-library' );
	wp_dequeue_style ( 'veryserious-fonts' );
	wp_dequeue_style ( 'veryserious-base-style' );
	wp_dequeue_style ( 'current-template-style' );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_stuff', 10 );

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
