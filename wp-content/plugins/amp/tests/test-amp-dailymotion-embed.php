<?php

class AMP_DailyMotion_Embed_Test extends WP_UnitTestCase {
	public function get_conversion_data() {
		return array(
			'no_embed' => array(
				'<p>Hello world.</p>',
				'<p>Hello world.</p>' . PHP_EOL,
			),

			'url_simple' => array(
				'https://www.dailymotion.com/video/x5awwth' . PHP_EOL,
				'<p><amp-dailymotion data-videoid="x5awwth" layout="responsive" width="600" height="338"></amp-dailymotion></p>' . PHP_EOL,
			),

			'url_with_title' => array(
				'http://www.dailymotion.com/video/x5awwth_snatched-official-trailer-2-hd_shortfilms' . PHP_EOL,
				'<p><amp-dailymotion data-videoid="x5awwth" layout="responsive" width="600" height="338"></amp-dailymotion></p>' . PHP_EOL,
			),

			'shortcode_unnamed_attr_as_id' => array(
				'[dailymotion x5awwth]' . PHP_EOL,
				'<amp-dailymotion data-videoid="x5awwth" layout="responsive" width="600" height="338"></amp-dailymotion>' . PHP_EOL,
			),

			'shortcode_named_attr_as_id' => array(
				'[dailymotion id=x5awwth]' . PHP_EOL,
				'<amp-dailymotion data-videoid="x5awwth" layout="responsive" width="600" height="338"></amp-dailymotion>' . PHP_EOL,
			),

		);
	}

	/**
	 * @dataProvider get_conversion_data
	 */
	public function test__conversion( $source, $expected ) {
		$embed = new AMP_DailyMotion_Embed_Handler();
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
				'https://www.dailymotion.com/video/x5awwth' . PHP_EOL,
				array( 'amp-dailymotion' => true ),
			),
		);
	}

	/**
	 * @dataProvider get_scripts_data
	 */
	public function test__get_scripts( $source, $expected ) {
		$embed = new AMP_DailyMotion_Embed_Handler();
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
