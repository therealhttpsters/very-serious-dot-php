<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package veryserious
 */

?>

		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			
			<?php
				veryserious_posted_on();
				veryserious_posted_by();
				veryserious_comments_link();
			?>
		
			<?php
		endif;
		?>
		<?php

		$htmlcontent = get_the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. 
						Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 
							'veryserious' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
		);

		// strip everything BUT the tags here
		$htmlcontent_0 = 
			strip_tags( 
				$htmlcontent , 
				'<p><br><li><ul><ol><a><h2><h3><h4><h5><h6><i><b><u><em><strong><span>' 
			);

		$pattern_array = array(
			array( /* classes */ '/(<[^>]+) class=".*?"/i', '$1' ),
			array( /* styles */ '/(<[^>]+) style=".*?"/i', '$1' ),
			array( /* god mode 1 */ '/<([^<\/>]*)>([\s]*?|(?R))<\/\1>/imsU', '' ),
			array( /* god mode 2 */ '/<([^<\/>]*)>([\s]*?|(?R))<\/\1>/imsU', '' )
		);

		foreach ( $pattern_array as $pattern ) {
			$htmlcontent_0 = preg_replace( $pattern[0] , $pattern[1], $htmlcontent_0 );
		}
		
		$htmlcontent_final = $htmlcontent_0 . 
		'<I>This is article <u>post-' . get_the_ID() . '</u>, written with love :-)</I><BR><BR>';

		echo $htmlcontent_final;

		// echo 'dank memes never die'; 
		// die();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . 
				esc_html__( 'Pages:', 'veryserious' ),
				'after'  => '</div>',
			)
		);
?>
<?php
	veryserious_post_categories();
	veryserious_post_tags();
	veryserious_edit_post_link();
?>

<?php
	if ( is_singular() ) :
		the_post_navigation(
			array(
				'prev_text' => '<div class="post-navigation-sub"><span>' . esc_html__( 'Previous:', 'veryserious' ) . '</span></div>%title',
				'next_text' => '<div class="post-navigation-sub"><span>' . esc_html__( 'Next:', 'veryserious' ) . '</span></div>%title',
			)
		);

		// If comments are open or we have at least one comment, load up the comment template.
		// if ( comments_open() || get_comments_number() ) :
		//	comments_template();
		// endif;
	endif;
