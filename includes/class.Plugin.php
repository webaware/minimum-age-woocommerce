<?php
namespace webaware\min_age_woo;

use \MinAgeWooRequires as Requires;

if (!defined('ABSPATH')) {
	exit;
}

/**
* class for managing the plugin
*/
class Plugin {

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
	* check for compatibility problems, and deal with them, before hooking up the plugin
	*/
	public function pluginStart() {
		add_action('init', 'min_age_woo_load_text_domain', 5);
		add_filter('plugin_row_meta', [$this, 'pluginDetailsLinks'], 10, 2);
		add_action('admin_init', [$this, 'adminInit'], 5);

		if (!$this->checkPrequisites()) {
			return;
		}

		require_once MIN_AGE_WOO_ROOT . 'includes/class.Checkout.php';
		Checkout::getInstance()->addHooks();

		add_filter('woocommerce_get_settings_pages', [$this, 'wooGetSettingsPages']);
	}

	/**
	* check prerequisites, add notices and return false if not met
	* @return bool
	*/
	public function checkPrequisites() {
		$requires = new Requires();

		if (!function_exists('WC')) {
			$requires->addNotice(
				esc_html__('Will not function without WooCommerce', 'minimum-age-woocommerce')
			);
			return false;
		}

		if (version_compare(WC()->version, MIN_VERSION_WOOCOMMERCE, '<')) {
			$requires->addNotice(
				/* translators: %1$s: minimum required version number, %2$s: installed version number */
				sprintf(esc_html__('Requires WooCommerce version %1$s or higher; your website has WooCommerce version %2$s', 'minimum-age-woocommerce'),
				esc_html(MIN_VERSION_WOOCOMMERCE), esc_html(WC()->version))
			);
			return false;
		}

		return true;
	}

	/**
	* admin init action
	*/
	public function adminInit() {
		if (current_user_can('manage_options')) {
			add_action('plugin_action_links_' . MIN_AGE_WOO_NAME, [$this, 'pluginActionLinks']);
		}
	}

	/**
	* add our settings class to WooCommerce
	* @param array $settings
	* @return array
	*/
	public function wooGetSettingsPages($settings) {
		require_once MIN_AGE_WOO_ROOT . 'includes/class.Settings.php';

		$settings[] = new Settings();

		return $settings;
	}

	/**
	* add plugin action links
	*/
	public function pluginActionLinks($links) {
		// add settings link
		$settingsURL = admin_url('admin.php?page=wc-settings&tab=minimum-age-woocommerce');
		$settings_link = sprintf('<a href="%s">%s</a>', esc_url($settingsURL), _x('Settings', 'plugin details links', 'minimum-age-woocommerce'));
		array_unshift($links, $settings_link);

		return $links;
	}

	/**
	* action hook for adding plugin details links
	*/
	public function pluginDetailsLinks($links, $file) {
		if ($file === MIN_AGE_WOO_NAME) {
			$links[] = sprintf('<a href="https://wordpress.org/support/plugin/minimum-age-woocommerce" rel="noopener" target="_blank">%s</a>', _x('Get Help', 'plugin details links', 'minimum-age-woocommerce'));
			$links[] = sprintf('<a href="https://wordpress.org/plugins/minimum-age-woocommerce/" rel="noopener" target="_blank">%s</a>', _x('Rating', 'plugin details links', 'minimum-age-woocommerce'));
			$links[] = sprintf('<a href="https://translate.wordpress.org/projects/wp-plugins/minimum-age-woocommerce" rel="noopener" target="_blank">%s</a>', _x('Translate', 'plugin details links', 'minimum-age-woocommerce'));
			$links[] = sprintf('<a href="https://shop.webaware.com.au/donations/?donation_for=Minimum+Age+for+WooCommerce" rel="noopener" target="_blank">%s</a>', _x('Donate', 'plugin details links', 'minimum-age-woocommerce'));
		}

		return $links;
	}

}
