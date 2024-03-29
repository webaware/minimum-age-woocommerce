# Minimum Age for WooCommerce
Contributors: webaware
Plugin Name: Minimum Age for WooCommerce
Plugin URI: https://shop.webaware.com.au/downloads/minimum-age-for-woocommerce/
Author URI: https://shop.webaware.com.au/
Donate link: https://shop.webaware.com.au/donations/?donation_for=Minimum+Age+for+WooCommerce
Tags: woocommerce, checkout, age
Requires at least: 4.2
Tested up to: 6.4
Requires PHP: 5.6
Stable tag: 1.1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Restrict purchase through the WooCommerce checkout by age

## Description

Add a checkout question for the customer's date of birth, and enforce a minimum age. The customer cannot checkout if their given date of birth means they are younger than the minimum age.

### Requirements

* WooCommerce 3.0 or greater
* PHP 5.6 or greater

### Translations

If you'd like to help out by translating this plugin, please [sign up for an account and dig in](https://translate.wordpress.org/projects/wp-plugins/minimum-age-woocommerce).

### Contributions

* [Fork me on GitHub](https://github.com/webaware/minimum-age-woocommerce/)

### Privacy

The customer's date of birth is recorded, so that transactions can be audited for compliance with minimum age legislation. The customer's date of birth is transmitted in order confirmation and notification emails. This information is not shared with any other parties.

## Frequently Asked Questions

### How can I set the minimum age?

The default minimum age is 18. You can change it the WooCommerce settings:

WooCommerce > Settings > Minimum Age > Minimum age

### How can I change the order of the date fields?

The default order of the birth date fields is day, month, year. You can choose a different layout in the settings:

WooCommerce > Settings > Minimum Age > Date layout

### Can I show the date of birth question conditionally?

There is a filter hook `minimum_age_woo_show_question` that allows developers to hide the date of birth question if it isn't required, e.g. only show for products in certain categories. It accepts a single boolean parameter, and returns a boolean: true to show the question, otherwise false.

## Screenshots

1. WooCommerce settings
2. The birth date question in the checkout, showing an error message

## Upgrade Notice

### 1.1.0

supports WooCommerce HPOS (high performance order storage); adds filter hook mininum_age_woo_show_question; tested to WooCommerce 8.2

## Changelog

The full changelog can be found [on GitHub](https://github.com/webaware/minimum-age-woocommerce/blob/master/changelog.md). Recent entries:

### 1.1.0

Released 2023-10-31

* fixed: support for WooCommerce HPOS (high performance order storage)
* added: filter hook `minimum_age_woo_show_question` allowing hookers to conditionally suppress the age question
* changed: marked as tested up to WooCommerce 8.2
