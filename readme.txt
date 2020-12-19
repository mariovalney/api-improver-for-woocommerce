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

We support V3.

= /products =

Will search for a category/tag by "name" and "slug" (in this order) if "id" is not provided.

In both cases, **we will not** create a new product category or tag. You can use the "aifw_api_v1_products_search_for_terms" filter to create it and return the "term_id".

Will search for attribute ID if it's not provided. Check [wc_attribute_taxonomy_id_by_name](https://woocommerce.github.io/code-reference/files/woocommerce-includes-wc-attribute-functions.html#function_wc_attribute_taxonomy_id_by_name) for more details.

= How to Use =

Easy and quick!

Just activate "API Improver for WooCommerce" and it's done. No configurations.

= Translations =

You can [translate API Improver for WooCommerce](https://translate.wordpress.org/projects/wp-plugins/api-improver-for-woocommerce) to your language.

= Review =

We would be grateful for a [review here](https://wordpress.org/support/plugin/api-improver-for-woocommerce/reviews/).

= Support =

* WooCommerce - 4.8 (API Version 3 supports 3.5.x or later, but we did not test it)

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

= I want to add my customization to endpoints =

Check filters on endpoints classes with "request_for_prepare_object_for_database" end.

= Can I help you? =

Yes! Visit [GitHub repository](https://github.com/mariovalney/api-improver-for-woocommerce).

== Screenshots ==

1. Request to create a Product with a category without ID.
2. Example to update a Product with both categories with and without ID.

== Changelog ==

= 1.0 =

* It's alive!
* Improved endpoint "/products" to accept category/tag by "name" and "slug" if "id" is not provided.
* Improved endpoint "/products" to search for taxonomies by "name" for attributes if "id" is not provided.

== Upgrade Notice ==

= 1.0.0 =

It's alive!
