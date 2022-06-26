<?php
use webaware\min_age_woo\Checkout;
use webaware\min_age_woo\Plugin;

use Yoast\WPTestUtils\BrainMonkey\TestCase;

/**
 * test whether plugin loads correctly
 */
class PluginTest extends TestCase {

	/**
	 * can get instance of plugin
	 */
	public function test_plugin() {
		$this->assertTrue(Plugin::getInstance() instanceof Plugin);
	}

	/**
	 * can get instance of Checkout handler
	 */
	public function test_plugin_start() {
		$this->assertTrue(Checkout::getInstance() instanceof Checkout);
	}

}
