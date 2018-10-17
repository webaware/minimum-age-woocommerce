<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<div class="notice notice-error">
	<p>
		<?= min_age_woo_external_link(
				sprintf(esc_html__('Minimum Age for WooCommerce requires PHP %1$s or higher; your website has PHP %2$s which is {{a}}old, obsolete, and unsupported{{/a}}.', 'minimum-age-woocommerce'),
					esc_html(EWAY_PAYMENTS_MIN_PHP), esc_html(PHP_VERSION)),
				'https://secure.php.net/supported-versions.php'
			); ?>
	</p>
	<p><?php printf(esc_html__('Please upgrade your website hosting. At least PHP %s is recommended.', 'minimum-age-woocommerce'), '7.1'); ?></p>
</div>
