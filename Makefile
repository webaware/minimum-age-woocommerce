PKG_NAME			:= minimum-age-woocommerce
PKG_VERSION			:= $(shell sed -rn 's/^Version: (.*)/\1/p' $(PKG_NAME).php)

ZIP					:= .dist/$(PKG_NAME)-$(PKG_VERSION).zip
FIND_PHP			:= find . -path ./vendor -prune -o -path ./node_modules -prune -o -path './.*' -o -name '*.php'
LINT_PHP			:= $(FIND_PHP) -exec php -l '{}' \; >/dev/null
SNIFF_PHP			:= vendor/bin/phpcs -ps
SNIFF_PHP_5			:= $(SNIFF_PHP) --standard=phpcs-5.2.xml
SRC_PHP				:= $(shell $(FIND_PHP) -print)

.PHONY: all lint lint-php test zip wpsvn

all:
	@echo please see Makefile for available builds / commands

# release product

zip: $(ZIP)

$(ZIP): $(SRC_PHP) static/css/* *.md *.txt
	rm -rf .dist
	mkdir .dist
	git archive HEAD --prefix=$(PKG_NAME)/ --format=zip -9 -o $(ZIP)

# WordPress plugin directory

wpsvn: lint
	svn up .wordpress.org
	rm -rf .wordpress.org/trunk
	mkdir .wordpress.org/trunk
	git archive HEAD --format=tar | tar x --directory=.wordpress.org/trunk

# code linters

lint: lint-php

lint-php:
	@echo PHP lint...
	@$(FIND_PHP) -exec php7.3 -l '{}' \; >/dev/null
	@vendor/bin/phpcs -ps
	@vendor/bin/phpcs -ps --standard=phpcs-5.2.xml

# tests

test: test-php73 test-php80 test-php81

test-php73: /tmp/wordpress-tests-lib
	php7.3 vendor/bin/phpunit

test-php74: /tmp/wordpress-tests-lib
	php7.4 vendor/bin/phpunit

test-php80: /tmp/wordpress-tests-lib
	php8.0 vendor/bin/phpunit

test-php81: /tmp/wordpress-tests-lib
	php8.1 vendor/bin/phpunit

test-php82: /tmp/wordpress-tests-lib
	php8.2 vendor/bin/phpunit

/tmp/wordpress-tests-lib:
	bin/install-wp-tests.sh wp_test website website localhost nightly
	sed -i "2i define('WP_DEBUG_LOG', __DIR__ . '/debug.log');" /tmp/wordpress-tests-lib/wp-tests-config.php
