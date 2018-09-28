<?php
namespace webaware\min_age_woo;

if (!defined('ABSPATH')) {
	exit;
}

// prerequisites
const MIN_VERSION_WOOCOMMERCE		= '3.0';

// settings names
const SETTING_CHECKOUT_TITLE		= 'min_age_woo_checkout_title';
const SETTING_CHECKOUT_DESCRIPTION	= 'min_age_woo_checkout_description';
const SETTING_ERROR_UNDER_AGE		= 'min_age_woo_error_under_age';
const SETTING_MIN_AGE				= 'min_age_woo_min_age';
const SETTING_DATE_LAYOUT			= 'min_age_woo_date_layout';

/**
* kick start the plugin
*/
add_action('plugins_loaded', function () {
	require MIN_AGE_WOO_ROOT . 'includes/class.Plugin.php';
	$plugin = Plugin::getInstance();
	$plugin->pluginStart();
}, 5);

/**
* show admin notice that WooCommerce needs upgrading
*/
function notice_woocommerce_version() {
	if (min_age_woo_can_show_admin_notices()) {
		include MIN_AGE_WOO_ROOT . 'views/requires-woocommerce-version.php';
	}
}

/**
* get setting default value
* @param string $setting
* @return string
*/
function get_setting_default($setting) {
	switch ($setting) {

		case SETTING_MIN_AGE:
			return '18';

		case SETTING_CHECKOUT_TITLE:
			return _x('Verify your age', 'checkout section default', 'minimum-age-woocommerce');

		case SETTING_CHECKOUT_DESCRIPTION:
			return _x('The date of birth of the purchaser is required to be recorded with the order as proof of age.', 'checkout section default', 'minimum-age-woocommerce');

		case SETTING_ERROR_UNDER_AGE:
			return __('You may not place an order on this shop if you are under {{age}}.', 'minimum-age-woocommerce');

	}

	return '';
}

/**
* get a string posted from the browser
* @param string $name
* @return string|false
*/
function get_posted_string($name) {
	static $posted = false;

	if ($posted === false) {
		$posted = wp_unslash($_POST);
	}

	return isset($posted[$name]) ? sanitize_text_field($posted[$name]) : false;
}
