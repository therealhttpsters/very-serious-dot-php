<?php

class AMP_Instagram_Embed_Test extends WP_UnitTestCase {
	public function get_conversion_data() {
		return array(
			'no_embed'                 => array(
				'<p>Hello world.</p>',
				'<p>Hello world.</p>' . PHP_EOL,
			),
			'simple_url'               => array(
				'https://instagram.com/p/7-l0z_p4A4/' . PHP_EOL,
				'<p><amp-instagram data-shortcode="7-l0z_p4A4" data-captioned layout="responsive" width="600" height="600"></amp-instagram></p>' . PHP_EOL,
			),

			'short_url'                => array(
				'https://instagr.am/p/7-l0z_p4A4' . PHP_EOL,
				'<p><amp-instagram data-shortcode="7-l0z_p4A4" data-captioned layout="responsive" width="600" height="600"></amp-instagram></p>' . PHP_EOL,
			),

			'shortcode_simple'         => array(
				'[instagram url=https://www.instagram.com/p/BIyO4vXjE6b]' . PHP_EOL,
				'<amp-instagram data-shortcode="BIyO4vXjE6b" data-captioned layout="responsive" width="600" height="600"></amp-instagram>' . PHP_EOL,
			),

			'shortcode_url_with_query' => array(
				'[instagram url=https://www.instagram.com/p/BIyO4vXjE6b/?taken-by=natgeo]' . PHP_EOL,
				'<amp-instagram data-shortcode="BIyO4vXjE6b" data-captioned layout="responsive" width="600" height="600"></amp-instagram>' . PHP_EOL,
			),

			'shortcode_with_short_url' => array(
				'[instagram url=https://instagr.am/p/7-l0z_p4A4]' . PHP_EOL,
				'<amp-instagram data-shortcode="7-l0z_p4A4" data-captioned layout="responsive" width="600" height="600"></amp-instagram>' . PHP_EOL,
			),
		);
	}

	/**
	 * Test conversion.
	 *
	 * @dataProvider get_conversion_data
	 * @param string $source   Source.
	 * @param string $expected Expected.
	 */
	public function test__conversion( $source, $expected ) {
		$embed = new AMP_Instagram_Embed_Handler();
		$embed->register_embed();
		$filtered_content = apply_filters( 'the_content', $source );

		$this->assertEquals( $expected, $filtered_content );
	}

	/**
	 * Get scripts data.
	 *
	 * @return array
	 */
	public function get_scripts_data() {
		return array(
			'not_converted' => array(
				'<p>Hello World.</p>',
				array(),
			),
			'converted'     => array(
				'https://instagram.com/p/7-l0z_p4A4/' . PHP_EOL,
				array( 'amp-instagram' => true ),
			),
		);
	}

	/**
	 * Test get_scripts().
	 *
	 * @dataProvider get_scripts_data
	 * @param string $source   Source.
	 * @param array  $expected Expected.
	 */
	public function test__get_scripts( $source, $expected ) {
		$embed = new AMP_Instagram_Embed_Handler();
		$embed->register_embed();
		$source = apply_filters( 'the_content', $source );

		$whitelist_sanitizer = new AMP_Tag_And_Attribute_Sanitizer( AMP_DOM_Utils::get_dom_from_content( $source ) );
		$whitelist_sanitizer->sanitize();

		$scripts = array_merge(
			$embed->get_scripts(),
			$whitelist_sanitizer->get_scripts()
		);

		$this->assertEquals( $expected, $scripts );
	}

	/**
	 * Data for test__raw_embed_sanitizer.
	 *
	 * @return array
	 */
	public function get_raw_embed_dataset() {
		return array(
			'no_embed'                               => array(
				'<p>Hello world.</p>',
				'<p>Hello world.</p>',
			),
			'embed_blockquote_without_instagram'     => array(
				'<blockquote><p>lorem ipsum</p></blockquote>',
				'<blockquote><p>lorem ipsum</p></blockquote>',
			),

			'blockquote_embed'                       => array(
				wpautop( '<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/BhsgU3jh6xE/"><div style="padding: 8px;">Lorem ipsum</div></blockquote> <script async defer src="//www.instagram.com/embed.js"></script>' ), // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript, WordPress.Arrays.ArrayDeclarationSpacing.ArrayItemNoNewLine
				'<amp-instagram data-shortcode="BhsgU3jh6xE" layout="responsive" width="600" height="600"></amp-instagram>' . "\n\n",
			),

			'blockquote_embed_notautop'              => array(
				'<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/BhsgU3jh6xE/"><div style="padding: 8px;">Lorem ipsum</div></blockquote> <script async defer src="//www.instagram.com/embed.js"></script>', // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript, WordPress.Arrays.ArrayDeclarationSpacing.ArrayItemNoNewLine
				'<amp-instagram data-shortcode="BhsgU3jh6xE" layout="responsive" width="600" height="600"></amp-instagram> ',
			),

			'blockquote_embed_with_caption'          => array(
				wpautop( '<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/BhsgU3jh6xE/" data-instgrm-captioned><div style="padding: 8px;">Lorem ipsum</div></blockquote> <script async defer src="//www.instagram.com/embed.js"></script>' ), // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript, WordPress.Arrays.ArrayDeclarationSpacing.ArrayItemNoNewLine
				'<amp-instagram data-shortcode="BhsgU3jh6xE" layout="responsive" width="600" height="600" data-captioned=""></amp-instagram>' . "\n\n",
			),

			'blockquote_embed_with_caption_notautop' => array(
				'<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/BhsgU3jh6xE/" data-instgrm-captioned><div style="padding: 8px;">Lorem ipsum</div></blockquote> <script async defer src="//www.instagram.com/embed.js"></script>', // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript, WordPress.Arrays.ArrayDeclarationSpacing.ArrayItemNoNewLine
				'<amp-instagram data-shortcode="BhsgU3jh6xE" layout="responsive" width="600" height="600" data-captioned=""></amp-instagram> ',
			),
		);
	}

	/**
	 * Test raw_embed_sanitizer.
	 *
	 * @param string $source  Content.
	 * @param string $expected Expected content.
	 * @dataProvider get_raw_embed_dataset
	 * @covers AMP_Instagram_Embed_Handler::sanitize_raw_embeds()
	 */
	public function test__raw_embed_sanitizer( $source, $expected ) {
		$dom   = AMP_DOM_Utils::get_dom_from_content( $source );
		$embed = new AMP_Instagram_Embed_Handler();

		$embed->sanitize_raw_embeds( $dom );

		$content = AMP_DOM_Utils::get_content_from_dom( $dom );
		$content = preg_replace( '/(?<=>)\s+(?=<)/', '', $content );

		$this->assertEquals( $expected, $content );
	}
}
