<?php
namespace webaware\min_age_woo;

if (!defined('ABSPATH')) {
	exit;
}

/**
* class for managing the plugin
*/
class Checkout {

	const FIELD_DOB_DAY			= 'min_age_woo_dob_day';
	const FIELD_DOB_MONTH		= 'min_age_woo_dob_month';
	const FIELD_DOB_YEAR		= 'min_age_woo_dob_year';
	const FIELD_AGE				= 'min_age_woo_dob_age';

	/**
	* static method for getting the instance of this singleton object
	* @return self
	*/
	public static function getInstance() {
		static $instance = null;

		if ($instance === null) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	* hide constructor
	*/
	private function __construct() { }

	/**
	* add hooks to manage checkout interactions
	*/
	public function addHooks() {
		$question_hook = apply_filters('mininum_age_woo_checkout_hook', 'woocommerce_checkout_before_customer_details');

		add_action($question_hook, [$this, 'showQuestion']);
		add_action('woocommerce_checkout_process', [$this, 'confirmAge']);
		add_action('woocommerce_checkout_update_order_meta', [$this, 'saveAge']);
		add_action('woocommerce_email_order_meta_fields', [$this, 'showInEmails'], 10, 3);
		add_action('woocommerce_admin_order_data_after_billing_address', [$this, 'showInAdmin']);
		add_filter('woocommerce_enqueue_styles', [$this, 'enqueueStyles']);
	}

	/**
	* maybe enqueue styles for the checkout
	* @param array $stylesheets
	* @return array
	*/
	public function enqueueStyles($stylesheets) {
		if (is_checkout()) {
			$ver = SCRIPT_DEBUG ? time() : MIN_AGE_WOO_VERSION;

			$stylesheets['minimum-age-woocommerce'] = [
				'src'		=> plugins_url('css/checkout.css', MIN_AGE_WOO_FILE),
				'deps'		=> '',
				'media'		=> 'all',
				'version'	=> $ver,
			];
		}
		return $stylesheets;
	}

	/**
	* show fields asking customer for their date of birth
	*/
	public function showQuestion() {
		$checkout		= WC()->checkout();

		$this_year		= (int) date('Y');
		$title			= get_option(SETTING_CHECKOUT_TITLE, get_setting_default(SETTING_CHECKOUT_TITLE));
		$description	= get_option(SETTING_CHECKOUT_DESCRIPTION, get_setting_default(SETTING_CHECKOUT_DESCRIPTION));

		$fields = [

			'day'	=>	woocommerce_form_field(self::FIELD_DOB_DAY, [
							'id'			=>	self::FIELD_DOB_DAY,
							'label'			=> esc_html_x('Day', 'checkout field label', 'minimum-age-woocommerce'),
							'type'			=> 'number',
							'required'		=> true,
							'class'			=> ['min-age-woo-field'],
							'return'		=> true,
							'custom_attributes'	=>	[
														'min'	=> '1',
														'max'	=> '31',
													],
						], $checkout->get_value(self::FIELD_DOB_DAY)),

			'month'	=>	woocommerce_form_field(self::FIELD_DOB_MONTH, [
							'id'			=>	self::FIELD_DOB_MONTH,
							'label'			=> esc_html_x('Month', 'checkout field label', 'minimum-age-woocommerce'),
							'type'			=> 'number',
							'required'		=> true,
							'class'			=> ['min-age-woo-field'],
							'return'		=> true,
							'custom_attributes'	=>	[
														'min'	=> '1',
														'max'	=> '12',
													],
						], $checkout->get_value(self::FIELD_DOB_MONTH)),

			'year'	=>	woocommerce_form_field(self::FIELD_DOB_YEAR, [
							'id'			=>	self::FIELD_DOB_YEAR,
							'label'			=> esc_html_x('Year', 'checkout field label', 'minimum-age-woocommerce'),
							'type'			=> 'number',
							'required'		=> true,
							'class'			=> ['min-age-woo-field'],
							'return'		=> true,
							'custom_attributes'	=>	[
														'min'	=> $this_year - 125,
														'max'	=> $this_year,
													],
						], $checkout->get_value(self::FIELD_DOB_YEAR)),

		];

		$fields = $this->sortFields($fields);

		include MIN_AGE_WOO_ROOT . 'views/checkout-fields-ask-age.php';
	}

	/**
	* sort the age question fields according to settings
	* @param array $fields
	* @return $fields
	*/
	protected function sortFields($fields) {
		switch (get_option(SETTING_DATE_LAYOUT, 'dmy')) {

			case 'mdy':
				return [
					'month'		=> $fields['month'],
					'day'		=> $fields['day'],
					'year'		=> $fields['year'],
				];

			case 'ymd':
				return [
					'year'		=> $fields['year'],
					'month'		=> $fields['month'],
					'day'		=> $fields['day'],
				];

		}

		// assume original array is dmy
		return $fields;
	}

	/**
	* confirm that customer's age meets minimum age limit, raise an error if it doesn't
	*/
	public function confirmAge() {
		$day		= get_posted_string(self::FIELD_DOB_DAY);
		$month		= get_posted_string(self::FIELD_DOB_MONTH);
		$year		= get_posted_string(self::FIELD_DOB_YEAR);
		$this_year	= (int) date('Y');
		$min_year	= $this_year - 125;
		$min_age	= get_option(SETTING_MIN_AGE, get_setting_default(SETTING_MIN_AGE));
		$latest		= strtotime("-$min_age years");
		$errors		= 0;

		if (empty($day) || !is_numeric($day) || $day < 1 || $day > 31) {
			wc_add_notice(__('The day of your birth date must be a number from 1 to 31.', 'minimum-age-woocommerce'), 'error');
			$errors++;
		}
		if (empty($month) || !is_numeric($month) || $month < 1 || $month > 12) {
			wc_add_notice(__('The month of your birth date must be a number from 1 to 12.', 'minimum-age-woocommerce'), 'error');
			$errors++;
		}
		if (empty($year) || !is_numeric($year) || $year < $min_year || $year > $this_year) {
			wc_add_notice(sprintf(__('The year of your birth date must be a number from %1$s to %2$s.', 'minimum-age-woocommerce'), $min_year, $this_year), 'error');
			$errors++;
		}

		if ($errors === 0 && !checkdate($month, $day, $year)) {
			wc_add_notice(__('Please enter a valid birth date.', 'minimum-age-woocommerce'), 'error');
			$errors++;
		}

		if ($errors === 0) {
			$dob = mktime(0, 0, 0, $month, $day, $year);
			if ($dob > $latest) {
				$msg = str_replace('{{age}}', $min_age, get_option(SETTING_ERROR_UNDER_AGE, get_setting_default(SETTING_ERROR_UNDER_AGE)));
				wc_add_notice($msg, 'error');
				$errors++;
			}
		}
	}

	/**
	* save date of birth, and age, to the order
	* @param int $order_id
	*/
	public function saveAge($order_id) {
		$day		= get_posted_string(self::FIELD_DOB_DAY);
		$month		= get_posted_string(self::FIELD_DOB_MONTH);
		$year		= get_posted_string(self::FIELD_DOB_YEAR);
		$dob		= mktime(0, 0, 0, $month, $day, $year);
		update_post_meta($order_id, self::FIELD_AGE, date('Y-m-d', $dob));
	}

	/**
	* add date of birth to emails
	* @param array $keys
	* @param bool $sent_to_admin
	* @param mixed $order
	* @return array
	*/
	public function showInEmails($keys, $sent_to_admin, $order) {
		if (is_numeric($order)) {
			$order = wc_get_order($order);
		}

		$dob = get_post_meta($order->get_id(), self::FIELD_AGE, true);
		if ($dob) {
			$keys[self::FIELD_AGE] = [
				'label'		=> _x('Date of birth', 'order email field label', 'minimum-age-woocommerce'),
				'value'		=> format_date_of_birth($dob),
			];
		}

		return $keys;
	}

	/**
	* add date of birth to admin order detail
	* @param WC_Order $order
	*/
	public function showInAdmin($order) {
		$dob = get_post_meta($order->get_id(), self::FIELD_AGE, true);
		if ($dob) {
			$dob = format_date_of_birth($dob);
			printf('<p><strong>%s</strong>: %s</p>', esc_html_x('Date of birth', 'admin field label', 'minimum-age-woocommerce'), esc_html($dob));
		}
	}

}
