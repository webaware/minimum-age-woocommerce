<?php
namespace webaware\min_age_woo;

if (!defined('ABSPATH')) {
	exit;
}

/**
* kick start the plugin
*/
add_action('plugins_loaded', function () {
	require MIN_AGE_WOO_ROOT . 'includes/functions.php';
	require MIN_AGE_WOO_ROOT . 'includes/class.Plugin.php';
	Plugin::getInstance()->pluginStart();
}, 5);
