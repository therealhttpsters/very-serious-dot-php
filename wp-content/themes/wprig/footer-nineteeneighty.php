<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package veryserious
 */

?>
	<A href="<?php echo esc_url( __( 'https://wordpress.org/', 'veryserious' ) ); ?>">
		<?php
		/* translators: %s: CMS name, i.e. WordPress. */
		printf( esc_html__( 'Proudly powered by %s', 'veryserious' ), 'WordPress' );
		?>
	</A>
	<SPAN class="sep"> | </SPAN>
		<?php
			/* translators: 1: Theme name, 2: Theme author. */
			printf( esc_html__( 'Theme: %1$s by %2$s.', 'veryserious' ), '<a href="' . esc_url( 'https://github.com/veryserious/veryserious/' ) . '">Very Serious</a>', 'the contributors' );
		?>
	
<?php wp_footer(); ?>

</BODY>
</HTML>
