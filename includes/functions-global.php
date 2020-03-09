<?php
// NB: Minimum PHP version for this file is 5.3! No short array notation, no namespaces!

if (!defined('ABSPATH')) {
	exit;
}

/**
* maybe show notice of minimum PHP version failure
*/
function min_age_woo_fail_php_version() {
	min_age_woo_load_text_domain();

	$requires = new MinAgeWooRequires();

	$requires->addNotice(
		min_age_woo_external_link(
			/* translators: %1$s: minimum required version number, %2$s: installed version number */
			sprintf(esc_html__('It requires PHP %1$s or higher; your website has PHP %2$s which is {{a}}old, obsolete, and unsupported{{/a}}.', 'minimum-age-woocommerce'),
				esc_html(MIN_AGE_WOO_MIN_PHP), esc_html(PHP_VERSION)),
			'https://www.php.net/supported-versions.php'
		)
	);
	$requires->addNotice(
		/* translators: %s: minimum recommended version number */
		sprintf(esc_html__('Please upgrade your website hosting. At least PHP %s is recommended.', 'minimum-age-woocommerce'), '7.3')
	);
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
