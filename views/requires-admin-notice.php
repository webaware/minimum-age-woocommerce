<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<div class="notice notice-error">
	<p><?php esc_html_e('Minimum Age for WooCommerce is not fully active.', 'minimum-age-woocommerce'); ?></p>
	<ul style="list-style:disc;padding-left: 2em">
		<?php foreach ($notices as $notice): ?>
			<li><?php echo $notice; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
