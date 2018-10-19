<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package veryserious
 */

?>
<H2>article id="post-<?php the_ID(); ?>" <?php post_class(); ?></H2>

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


		// strip classes
		$pattern = '/(<[^>]+) class=".*?"/i';
		$htmlcontent_1 = 
			preg_replace(
				$pattern ,
				'$1' , 
				$htmlcontent
			);


		// strip inline styles
		$pattern = '/(<[^>]+) style=".*?"/i';
		$htmlcontent_2 = 
			preg_replace(
				$pattern ,
				'$1' , 
				$htmlcontent_1
			);


		// strip everything BUT the tags here
		$htmlcontent_3 = 
			strip_tags( 
				$htmlcontent_2 , 
				'<p><br><li><ul><ol><a>' 
			);


		// disregard tags, acquire acetone for stripping things down
		// props https://websupporter.net/blog/an-example-of-how-to-remove-empty-html-tags-with-php/
		$pattern = '/<([^<\/>]*)>([\s]*?|(?R))<\/\1>/imsU';
		$htmlcontent_final = 
			preg_replace(
				$pattern ,
				'' , 
					preg_replace(
						$pattern ,
						'' , 
						$htmlcontent_3
					)
				);
		
		echo $htmlcontent_final;

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
