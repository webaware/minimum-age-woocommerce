<?php
// NB: Minimum PHP version for this file is 5.3! No short array notation, no namespaces!

if (!defined('ABSPATH')) {
	exit;
}

/**
* maybe show notice of minimum PHP version failure
*/
function min_age_woo_fail_php_version() {
	if (min_age_woo_can_show_admin_notices()) {
		min_age_woo_load_text_domain();
		include MIN_AGE_WOO_ROOT . 'views/requires-php.php';
	}
}

/**
* test whether we can show admin-related notices
* @return bool
*/
function min_age_woo_can_show_admin_notices() {
	global $pagenow, $hook_suffix;

	// only on specific pages
	if ($pagenow !== 'plugins.php' && $hook_suffix !== 'woocommerce_page_wc-settings') {
		return false;
	}

	// only bother admins / plugin installers / option setters with this stuff
	if (!current_user_can('activate_plugins') && !current_user_can('manage_options')) {
		return false;
	}

	return true;
}

/**
* load text translations
*/
function min_age_woo_load_text_domain() {
	load_plugin_textdomain('minimum-age-woocommerce');
}

/**
* replace link placeholders with an external link
* @param string $template
* @param string $url
* @return string
*/
function min_age_woo_external_link($template, $url) {
	$search = array(
		'{{a}}',
		'{{/a}}',
	);
	$replace = array(
		sprintf('<a rel="noopener" target="_blank" href="%s">', esc_url($url)),
		'</a>',
	);
	return str_replace($search, $replace, $template);
}
