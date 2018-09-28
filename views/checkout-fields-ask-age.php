<?php
namespace webaware\min_age_woo;

if (!defined('ABSPATH')) {
	exit;
}
?>

<div id="min-age-woo-ask-dob">

	<h3><?= esc_html($title); ?></h3>

	<?php if (!empty($description)): ?>
	<p><?= esc_html($description); ?></p>
	<?php endif; ?>

	<?php
	foreach ($fields as $field) {
		echo $field;
	}
	?>

</div>
