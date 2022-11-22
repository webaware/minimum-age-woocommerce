# Minimum Age for WooCommerce

### 1.0.18, 2022-11-22

* fixed: filter hook `mininum_age_woo_checkout_hook` did not work from themes, only from plugins

### 1.0.17, 2022-06-26

* fixed: was breaking the `woocommerce_email_order_meta_fields` filter hook for other plugins
* changed: marked as tested up to WooCommerce 6.6

### 1.0.16, 2021-03-23

* fixed: date of birth in emails was one day behind for timezones behind UTC
* changed: marked as tested up to WooCommerce 5.1

### 1.0.15, 2021-02-12

* changed: marked as tested up to WooCommerce 5.0

### 1.0.14, 2021-01-11

* added: settings to enable/disable showing the customer's age in order emails
* changed: prefer `wp_date()` function when it is available
* changed: marked as tested up to WooCommerce 4.9

### 1.0.13, 2020-11-13

* fixed: formatted birthdates were not being translated
* changed: marked as tested up to WooCommerce 4.7

### 1.0.12, 2020-08-12

* changed: marked as tested up to WooCommerce 4.4

### 1.0.11, 2020-07-11

* changed: marked as tested up to WooCommerce 4.3
* added: filter hook `mininum_age_woo_checkout_hook` allowing developers to change where the fields show in the checkout

### 1.0.10, 2020-06-03

* changed: marked as tested up to WooCommerce 4.2

### 1.0.9, 2020-05-05

* changed: marked as tested up to WooCommerce 4.1

### 1.0.8, 2020-03-20

* fixed: fatal error on plugins page when searching for deactivated WooCommerce plugin

### 1.0.7, 2020-03-09

* changed: marked as tested up to WooCommerce 4.0

### 1.0.6, 2020-01-03

* changed: marked as tested up to WooCommerce 3.9

### 1.0.5, 2019-10-24

* changed: marked as tested up to WooCommerce 3.8

### 1.0.4, 2019-08-12

* changed: marked as tested up to WooCommerce 3.7

### 1.0.3, 2019-04-18

* changed: requires minimum PHP version of 5.6
* changed: marked as tested up to WooCommerce 3.6

### 1.0.2, 2018-11-05

* irony: view for PHP compatibility message used short echo tags not compatible with PHP < 5.4

### 1.0.1, 2018-10-17

* changed: marked as tested up to WooCommerce 3.5

### 1.0.0, 2018-09-29

* initial public release
