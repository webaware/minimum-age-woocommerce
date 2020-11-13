<?php
namespace webaware\min_age_woo;

if (!defined('ABSPATH')) {
	exit;
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

/**
 * format the birthday for display
 * @param string $dob
 * @return string
 */
function format_date_of_birth($dob) {
	$dob = strtotime($dob);
	return date_i18n(_x('jS F, Y', 'order email date format', 'minimum-age-woocommerce'), $dob);
}
