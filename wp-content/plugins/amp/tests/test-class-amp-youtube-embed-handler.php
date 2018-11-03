<?php
/**
 * Tests for AMP_YouTube_Embed_Handler.
 *
 * @package AMP
 * @since 0.7
 */

/**
 * Tests for AMP_YouTube_Embed_Handler.
 *
 * @covers AMP_YouTube_Embed_Handler
 */
class Test_AMP_YouTube_Embed_Handler extends WP_UnitTestCase {

	/**
	 * An instance of this embed handler.
	 *
	 * @var AMP_YouTube_Embed_Handler.
	 */
	public $handler;

	/**
	 * Set up each test.
	 */
	public function setUp() {
		parent::setUp();
		$this->handler = new AMP_YouTube_Embed_Handler();
	}

	/**
	 * Test video_override().
	 *
	 * @covers AMP_YouTube_Embed_Handler::video_override()
	 */
	public function test_video_override() {
		remove_all_filters( 'wp_video_shortcode_override' );
		$this->handler->register_embed();
		$youtube_id   = 'XOY3ZUO6P0k';
		$youtube_src  = 'https://youtu.be/' . $youtube_id;
		$attr_youtube = array(
			'src' => $youtube_src,
		);

		$youtube_shortcode = $this->handler->video_override( '', $attr_youtube );
		$this->assertContains( '<amp-youtube', $youtube_shortcode );
		$this->assertContains( $youtube_id, $youtube_shortcode );

		$vimeo_id        = '64086087';
		$vimeo_src       = 'https://vimeo.com/' . $vimeo_id;
		$attr_vimeo      = array(
			'src' => $vimeo_src,
		);
		$yimeo_shortcode = $this->handler->video_override( '', $attr_vimeo );
		$this->assertEquals( '', $yimeo_shortcode );

		$daily_motion_id        = 'x6bacgf';
		$daily_motion_src       = 'http://www.dailymotion.com/video/' . $daily_motion_id;
		$attr_daily_motion      = array(
			'src' => $daily_motion_src,
		);
		$daily_motion_shortcode = $this->handler->video_override( '', $attr_daily_motion );
		$this->assertEquals( '', $daily_motion_shortcode );
		$no_attributes = $this->handler->video_override( '', array() );
		$this->assertEquals( '', $no_attributes );
		remove_all_filters( 'wp_video_shortcode_override' );
	}

}
