<?php
use webaware\min_age_woo\Checkout;
use webaware\min_age_woo\Plugin;

/**
* test whether plugin loads correctly
*/
class PluginTest extends WP_UnitTestCase {

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
