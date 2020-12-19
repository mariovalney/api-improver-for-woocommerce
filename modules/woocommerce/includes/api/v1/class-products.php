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
            if ( ! empty( $request['categories'] ) ) {
                $this->search_and_save_terms( $product, $request['categories'], 'product_cat' );
            }

            if ( ! empty( $request['tags'] ) ) {
                $this->search_and_save_terms( $product, $request['tags'], 'product_tag' );
            }

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
            $properties['tags']['items']['properties']['id']['description'] = __( 'Tag ID (if empty we will search for a Tag by name or slug).', 'api-improver-for-woocommerce' );

            return $properties;
        }

        /**
         * Save terms (tags or categories) for products by name or slug
         *
         * @return void
         */
        private function search_and_save_terms( $product, $terms, $taxonomy ) {
            foreach ( $terms as $key => $value ) {
                if ( ! empty( $value['id'] ) ) {
                    continue;
                }

                $term_id = $this->search_for_terms( $value, $taxonomy );
                if ( empty( $term_id ) ) {
                    continue;
                }

                $terms[ $key ]['id'] = $term_id;
            }

            $term_ids = wp_list_pluck( $terms, 'id' );

            if ( $taxonomy === 'product_cat' ) {
                $product->set_category_ids( $term_ids );
            }

            if ( $taxonomy === 'product_tag' ) {
                $product->set_tag_ids( $term_ids );
            }
        }

        /**
         * Search for a category by name or slug
         *
         * @return integer
         */
        private function search_for_terms( $params, $taxonomy ) {
            if ( ! empty( $params['name'] ) ) {
                $term = get_term_by( 'name', $params['name'], $taxonomy );
                if ( ! empty( $term ) && ! empty( $term->term_id ) ) {
                    return (int) $term->term_id;
                }
            }

            if ( ! empty( $params['slug'] ) ) {
                $term = get_term_by( 'slug', $params['slug'], $taxonomy );
                if ( ! empty( $term ) && ! empty( $term->term_id ) ) {
                    return (int) $term->term_id;
                }
            }

            /**
             * Filter when we are not able to find a term by name/slug.
             *
             * Return a empty value to ignore or a valid ID to be added to Product.
             * You can use it to create a term and return it ID, for example.
             *
             * @param integer $term_id  The category/tag ID.
             * @param array   $params   The category/tag object.
             * @param string  $taxonomy The taxonomy (product_cat|product_tag).
             */
            return apply_filters( 'aifw_api_v1_products_search_for_terms', 0, $params, $taxonomy );
        }

    }

}
