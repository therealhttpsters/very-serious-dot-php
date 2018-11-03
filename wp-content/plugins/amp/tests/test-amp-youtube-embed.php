<?php

class AMP_YouTube_Embed_Test extends WP_UnitTestCase {
	public function get_conversion_data() {
		return array(
			'no_embed' => array(
				'<p>Hello world.</p>',
				'<p>Hello world.</p>' . PHP_EOL,
			),

			'url_simple' => array(
				'https://www.youtube.com/watch?v=kfVsfOSbJY0' . PHP_EOL,
				'<p><amp-youtube data-videoid="kfVsfOSbJY0" layout="responsive" width="600" height="338"></amp-youtube></p>' . PHP_EOL,
			),

			'url_short' => array(
				'https://youtu.be/kfVsfOSbJY0' . PHP_EOL,
				'<p><amp-youtube data-videoid="kfVsfOSbJY0" layout="responsive" width="600" height="338"></amp-youtube></p>' . PHP_EOL,
			),

			'url_with_querystring' => array(
				'http://www.youtube.com/watch?v=kfVsfOSbJY0&hl=en&fs=1&w=425&h=349' . PHP_EOL,
				'<p><amp-youtube data-videoid="kfVsfOSbJY0" layout="responsive" width="600" height="338"></amp-youtube></p>' . PHP_EOL,
			),

			// Several reports of invalid URLs that have multiple `?` in the URL.
			'url_with_querystring_and_extra_?' => array(
				'http://www.youtube.com/watch?v=kfVsfOSbJY0?hl=en&fs=1&w=425&h=349' . PHP_EOL,
				'<p><amp-youtube data-videoid="kfVsfOSbJY0" layout="responsive" width="600" height="338"></amp-youtube></p>' . PHP_EOL,
			),

			'shortcode_unnamed_attr_as_url' => array(
				'[youtube http://www.youtube.com/watch?v=kfVsfOSbJY0]' . PHP_EOL,
				'<amp-youtube data-videoid="kfVsfOSbJY0" layout="responsive" width="600" height="338"></amp-youtube>' . PHP_EOL,
			),
		);
	}

	/**
	 * @dataProvider get_conversion_data
	 */
	public function test__conversion( $source, $expected ) {
		$embed = new AMP_YouTube_Embed_Handler();
		$embed->register_embed();
		$filtered_content = apply_filters( 'the_content', $source );

		$this->assertEquals( $expected, $filtered_content );
	}

	public function get_scripts_data() {
		return array(
			'not_converted' => array(
				'<p>Hello World.</p>',
				array(),
			),
			'converted' => array(
				'https://www.youtube.com/watch?v=kfVsfOSbJY0' . PHP_EOL,
				array( 'amp-youtube' => true ),
			),
		);
	}

	/**
	 * @dataProvider get_scripts_data
	 */
	public function test__get_scripts( $source, $expected ) {
		$embed = new AMP_YouTube_Embed_Handler();
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
}
