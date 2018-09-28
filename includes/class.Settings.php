<?php
namespace webaware\min_age_woo;

if (!defined('ABSPATH')) {
	exit;
}

/**
* settings for this plugin
*/
class Settings extends \WC_Settings_Page {

	/**
	* initialise
	*/
	public function __construct() {
		$this->id    = 'minimum-age-woocommerce';
		$this->label = __('Minimum Age', 'minimum-age-woocommerce');

		parent::__construct();

		add_action('woocommerce_admin_settings_sanitize_option_' . SETTING_MIN_AGE, [$this, 'sanitiseInteger'], 10, 3);
	}

	/**
	* Get settings array
	* @param string $current_section
	* @return array
	*/
	public function get_settings($current_section = '') {
		$settings = [

			[
				'title'				=> __('Minimum Age', 'minimum-age-woocommerce'),
				'id'				=> 'min_age_woo_settings',
				'type'				=> 'title',
			],

			[
				'id' 				=> SETTING_CHECKOUT_TITLE,
				'title' 			=> _x('Checkout title', 'settings page', 'minimum-age-woocommerce'),
				'type' 				=> 'text',
				'default'			=> get_setting_default(SETTING_CHECKOUT_TITLE),
				'css'				=> 'width:100%',
			],

			[
				'id' 				=> SETTING_CHECKOUT_DESCRIPTION,
				'title' 			=> _x('Checkout description', 'settings page', 'minimum-age-woocommerce'),
				'type' 				=> 'textarea',
				'class'				=> 'input-text wide-input',
				'default'			=> get_setting_default(SETTING_CHECKOUT_DESCRIPTION),
			],

			[
				'id' 				=> SETTING_ERROR_UNDER_AGE,
				'title' 			=> _x('Under age error', 'settings page', 'minimum-age-woocommerce'),
				'type' 				=> 'text',
				'desc_tip' 			=> _x('The error displayed when the customer is under age.', 'settings page', 'minimum-age-woocommerce'),
				'desc'				=> _x('<code>{{age}}</code> will be replaced by the minimum age.', 'settings page', 'minimum-age-woocommerce'),
				'css'				=> 'width:100%',
				'default'			=> get_setting_default(SETTING_ERROR_UNDER_AGE),
			],

			[
				'id' 				=> SETTING_MIN_AGE,
				'title' 			=> _x('Minimum age', 'settings page', 'minimum-age-woocommerce'),
				'type' 				=> 'number',
				'default'			=> get_setting_default(SETTING_MIN_AGE),
				'desc_tip'			=> _x('The minimum age acceptable for the checkout, in whole years.', 'settings page', 'minimum-age-woocommerce'),
				'css' 				=> 'width:5em;',
				'custom_attributes' =>	[
											'min'	=> 10,
											'step'	=> 1,
										],
			],

			[
				'id' 				=> SETTING_DATE_LAYOUT,
				'title' 			=> _x('Date layout', 'settings page', 'minimum-age-woocommerce'),
				'desc_tip'			=> _x('The order in which the birth date fields appear.', 'settings page', 'minimum-age-woocommerce'),
				'default'			=> 'dmy',
				'type'				=> 'select',
				'class'				=> 'wc-enhanced-select',
				'options'			=>	[
											'dmy'	=> _x('day / month / year', 'date field layout', 'minimum-age-woocommerce'),
											'mdy'	=> _x('month / day / year', 'date field layout', 'minimum-age-woocommerce'),
											'ymd'	=> _x('year / month / day', 'date field layout', 'minimum-age-woocommerce'),
										],
			],

			[
				'id'				=> 'min_age_woo_settings',
				'type'				=> 'sectionend',
			],

		];

		return apply_filters('woocommerce_get_settings_' . $this->id, $settings, $current_section);
	}

	/**
	* fix up values for integer settings
	* @param string $value
	* @param array $option
	* @param string $raw_value
	* @return int
	*/
	public function sanitiseInteger($value, $option, $raw_value) {
		if ($raw_value === '') {
			$value = $option['default'];
		}
		else {
			$value = absint($raw_value);
		}

		return $value;
	}

}
