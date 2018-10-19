<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package veryserious
 */

/*
* Variables are set as Categories from WP posts.
* modern: '2010'
* earlyoughts: '2004'
* twok: '2000'
* nineteenninetyfour: '1994'
* nineteeneighty: '1980'
*/ 


$categories = get_the_category();

$header_name	=	'header.php';
$content_name	=	'content';
$sidebar_name	=	'sidebar.php';
$footer_name	=	'sidebar.php';

$first_category	= 	$categories[0]->name;

if ( ! empty( $categories ) ) {
	$header_name	= 	$first_category;
	$content_name 	= 	'content-' . $first_category;   
	$sidebar_name	= 	$first_category;
	$footer_name	= 	$first_category;
}


get_header( $header_name ); ?>

	<main id="primary" class="site-main">

	<?php

	if ( have_posts() ) :

		/**
		 * Include the component stylesheet for the content.
		 * This call runs only once on index and archive pages.
		 * At some point, override functionality should be built in similar to the template part below.
		 */
		wp_print_styles( array( 'veryserious-content' ) ); // Note: If this was already done it will be skipped.

		/* Display the appropriate header when required. */
		veryserious_index_header();

		/* Start the Loop. */
		while ( have_posts() ) :
			the_post();

			/*
			 * Include the Post-Type-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
			 */
			
			get_template_part( 'template-parts/' . $content_name, get_post_type() );
			

		endwhile;

		if ( ! is_singular() ) :
			the_posts_navigation();
		endif;

	else :

		get_template_part( 'template-parts/' . $content_name, 'none' );

	endif;
	?>

	</main><!-- #primary -->

<?php

if ( ! $first_category = 'nineteeneighty' ) { 
	get_sidebar( $sidebar_name );
	get_footer( $footer_name );
}