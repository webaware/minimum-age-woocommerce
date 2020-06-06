<?php
/*
Plugin Name: Minimum Age for WooCommerce
Plugin URI: https://shop.webaware.com.au/downloads/minimum-age-for-woocommerce/
Description: Restrict purchase through the WooCommerce checkout by age
Version: 1.0.11-dev
Author: WebAware
Author URI: https://shop.webaware.com.au/
Text Domain: minimum-age-woocommerce
WC requires at least: 3.0
WC tested up to: 4.2
*/

/*
copyright (c) 2018-2020 WebAware Pty Ltd (email : support@webaware.com.au)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if (!defined('ABSPATH')) {
	exit;
}

define('MIN_AGE_WOO_FILE', __FILE__);
define('MIN_AGE_WOO_ROOT', dirname(__FILE__) . '/');
define('MIN_AGE_WOO_NAME', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
define('MIN_AGE_WOO_MIN_PHP', '5.6');
define('MIN_AGE_WOO_VERSION', '1.0.11-dev');

require MIN_AGE_WOO_ROOT . 'includes/functions-global.php';
require MIN_AGE_WOO_ROOT . 'includes/class.Requires.php';

if (version_compare(PHP_VERSION, MIN_AGE_WOO_MIN_PHP, '<')) {
	add_action('admin_notices', 'min_age_woo_fail_php_version');
	return;
}

require MIN_AGE_WOO_ROOT . 'includes/bootstrap.php';
