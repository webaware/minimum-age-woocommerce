<?php
use const webaware\min_age_woo\SETTING_MIN_AGE;

use function webaware\min_age_woo\get_setting_default;
use function webaware\min_age_woo\format_date_of_birth;

/**
* test functions
*/
class FunctionsTest extends WP_UnitTestCase {

	/**
	* check default value for minimum age
	*/
	public function test_setting_min_age() {
		$this->assertTrue(get_setting_default(SETTING_MIN_AGE) === '18');
	}

	/**
	* check formatted date: basic call with 10th Jan 1999
	*/
	public function test_format_dob_basic() {
		$this->assertTrue(format_date_of_birth('1999-01-10') === '10th January, 1999');
	}

	/**
	* check formatted date: set timezone to Australia/Sydney
	*/
	public function test_format_dob_au_sydney() {
		update_option('timezone_string', 'Australia/Sydney');
		$this->assertTrue(format_date_of_birth('1999-01-10') === '10th January, 1999');
		update_option('timezone_string', '');
	}

	/**
	* check formatted date: set timezone to Pacific/Midway
	* this is the last point to roll over to a new day before the international dateline
	*/
	public function test_format_dob_us_midway() {
		update_option('timezone_string', 'Pacific/Midway');
		$this->assertTrue(format_date_of_birth('1999-01-10') === '10th January, 1999');
		update_option('timezone_string', '');
	}

}
