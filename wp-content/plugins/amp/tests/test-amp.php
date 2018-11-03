<?php
/**
 * Tests for amp.php.
 *
 * @package AMP
 */

/**
 * Tests for amp.php.
 */
class Test_AMP extends WP_UnitTestCase {

	/**
	 * Tear down and clean up.
	 */
	public function tearDown() {
		parent::tearDown();
		remove_theme_support( AMP_Theme_Support::SLUG );
	}

	/**
	 * Test amp_is_canonical().
	 *
	 * @covers \amp_is_canonical()
	 */
	public function test_amp_is_canonical() {
		remove_theme_support( AMP_Theme_Support::SLUG );
		$this->assertFalse( amp_is_canonical() );

		add_theme_support( AMP_Theme_Support::SLUG );
		$this->assertTrue( amp_is_canonical() );

		add_theme_support( AMP_Theme_Support::SLUG, array(
			'template_dir' => 'amp-templates',
		) );
		$this->assertFalse( amp_is_canonical() );

		add_theme_support( AMP_Theme_Support::SLUG, array(
			'paired'       => false,
			'template_dir' => 'amp-templates',
		) );
		$this->assertTrue( amp_is_canonical() );

		add_theme_support( AMP_Theme_Support::SLUG, array(
			'paired' => true,
		) );
		$this->assertFalse( amp_is_canonical() );

		add_theme_support( AMP_Theme_Support::SLUG, array(
			'custom_prop' => 'something',
		) );
		$this->assertTrue( amp_is_canonical() );
	}
}
