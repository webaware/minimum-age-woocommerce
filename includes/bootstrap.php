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
	require MIN_AGE_WOO_ROOT . 'includes/functions.php';
	require MIN_AGE_WOO_ROOT . 'includes/class.Plugin.php';
	Plugin::getInstance()->pluginStart();
}, 5);
