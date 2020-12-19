=== API Improver for WooCommerce ===
Contributors: mariovalney
Donate link: https://github.com/mariovalney/api-improver-for-woocommerce
Tags: woocommerce, api, rest, products, mariovalney
Requires at least: 4.7
Tested up to: 5.6
Requires PHP: 7.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin to improve your API REST.

== Description ==

Improve your WooCommerce API REST without config.

[WooCommerce](https://wordpress.org/plugins/woocommerce/ "Install it first, of course") is a awesome plugin used by 5+ million WordPress websites to create e-commerce.

It's awesome and we love it but sometimes we need more from API REST.

== Endpoints ==

= /products =

Will search for a category/tag by "name" and "slug" (in this order) if "id" is not provided.

In both cases, **we will not** create a new product category or tag. You can use the "aifw_api_v1_products_search_for_terms" filter to create it and return the "term_id".

= How to Use =

Easy and quick!

Just activate "API Improver for WooCommerce" and it's done. No configurations.

= Translations =

You can [translate API Improver for WooCommerce](https://translate.wordpress.org/projects/wp-plugins/api-improver-for-woocommerce) to your language.

= Review =

We would be grateful for a [review here](https://wordpress.org/support/plugin/api-improver-for-woocommerce/reviews/).

= Support =

* WooCommerce - 4.8

== Installation ==

First

* Install [WooCommerce](https://wordpress.org/plugins/woocommerce/) and activate it.

Next

* Install "API Improver for WooCommerce" by plugins dashboard.

Or

* Upload the entire `api-improver-for-woocommerce` folder to the `/wp-content/plugins/` directory.

Then

* Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Does it works for another e-commerce plugin? =

Nope. The intention here is to improve WooCommerce API REST.

= Can I help you? =

Yes! Visit [GitHub repository](https://github.com/mariovalney/api-improver-for-woocommerce).

== Screenshots ==

1. Request to create/update a Product with a category by name

== Changelog ==

= 1.0 =

* It's alive!

== Upgrade Notice ==

= 1.0.0 =

It's alive!
