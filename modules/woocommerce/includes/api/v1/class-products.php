<?php

/**
 * AIFW_Api_V1_Products
 *
 * @package         API_Improver_For_WooCommerce
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'AIFW_Api_V1_Products' ) ) {

    class AIFW_Api_V1_Products extends AIFW_Hook_Base {

        /**
         * Filter: 'woocommerce_rest_pre_insert_product_object'
         * @see wp-content/plugins/woocommerce/includes/rest-api/Controllers/Version1/class-wc-rest-products-v1-controller.php:728
         */
        public function filter_woocommerce_rest_pre_insert_product_object( $product, $request ) {
            if ( empty( $request['categories'] ) ) {
                return $product;
            }

            $categories = $request['categories'];
            foreach ( $categories as $key => $value ) {
                if ( ! empty( $value['id'] ) ) {
                    continue;
                }

                $category_id = $this->search_for_category( $value );
                if ( empty( $category_id ) ) {
                    continue;
                }

                $categories[ $key ]['id'] = $category_id;
            }

            $term_ids = wp_list_pluck( $categories, 'id' );
            $product->set_category_ids( $term_ids );

            return $product;
        }

        /**
         * Filter: 'woocommerce_rest_product_schema'
         *
         * @see wp-content/plugins/woocommerce/includes/rest-api/Controllers/Version3/class-wc-rest-controller.php:75
         * @see wp-content/plugins/woocommerce/includes/rest-api/Controllers/Version1/class-wc-rest-products-v1-controller.php:2093
         */
        public function filter_woocommerce_rest_product_schema( $properties ) {
            if ( empty( $properties['categories'] ) ) {
                return $properties;
            }

            $properties['categories']['items']['properties']['id']['description'] = __( 'Category ID (if empty we will search for a Category by name or slug).', 'api-improver-for-woocommerce' );

            return $properties;
        }

        /**
         * Search for a category by name or slug
         *
         * @return integer
         */
        private function search_for_category( $params ) {
            if ( ! empty( $params['name'] ) ) {
                $category = get_term_by( 'name', $params['name'], 'product_cat' );
                if ( ! empty( $category ) && ! empty( $category->term_id ) ) {
                    return (int) $category->term_id;
                }
            }

            if ( ! empty( $params['slug'] ) ) {
                $category = get_term_by( 'slug', $params['slug'], 'product_cat' );
                if ( ! empty( $category ) && ! empty( $category->term_id ) ) {
                    return (int) $category->term_id;
                }
            }

            return 0;
        }

    }

}
