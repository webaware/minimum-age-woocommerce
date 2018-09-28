<?php
namespace webaware\min_age_woo;

if (!defined('ABSPATH')) {
	exit;
}
?>

<div class="notice notice-error">
	<p><?= sprintf(esc_html__('Minimum Age for WooCommerce requires WooCommerce version %1$s or higher; your website has WooCommerce version %2$s', 'minimum-age-woocommerce'),
		esc_html(MIN_VERSION_WOOCOMMERCE), esc_html(WC()->version)); ?></p>
</div>
