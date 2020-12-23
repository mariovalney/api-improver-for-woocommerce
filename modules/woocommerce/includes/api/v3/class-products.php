<?php

/**
 * AIFW_Api_V3_Products_Controller
 *
 * @package         API_Improver_For_WooCommerce
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'AIFW_Api_V3_Products_Controller' ) && class_exists( 'WC_REST_Products_Controller' ) ) {

    class AIFW_Api_V3_Products_Controller extends WC_REST_Products_Controller {

        /**
         * Prepare a single product for create or update.
         *
         * @param  WP_REST_Request $request  Request object.
         * @param  bool            $creating If is creating a new object.
         * @return WP_Error|WC_Data
         */
        protected function prepare_object_for_database( $request, $creating = false ) {
            if ( ! empty( $request['attributes'] ) ) {
                $request['attributes'] = $this->search_attributes_without_id( $request['attributes'] );
            }

            if ( ! empty( $request['categories'] ) ) {
                $request['categories'] = $this->search_terms_without_id( $request['categories'], 'product_cat' );
            }

            if ( ! empty( $request['tags'] ) ) {
                $request['tags'] = $this->search_terms_without_id( $request['tags'], 'product_tag' );
            }

            /**
             * Filter request before prepare object for database.
             *
             * @param  WP_REST_Request $request  Request object.
             * @param  bool            $creating If is creating a new object.
             */
            $request = apply_filters( 'aifw_api_v3_products_request_for_prepare_object_for_database', $request, $creating );

            return parent::prepare_object_for_database( $request, $creating );
        }

        /**
         * Add attributes without ID to attributes array.
         *
         * @param  array  $attributes  Request object value for attributes.
         * @return array
         */
        private function search_attributes_without_id( $attributes ) {
            foreach ( $attributes as $key => $value ) {
                if ( ! empty( $value['id'] ) ) {
                    continue;
                }

                if ( ! empty( $value['name'] ) ) {
                    $attribute_id = wc_attribute_taxonomy_id_by_name( $value['name'] );
                    if ( ! empty( $attribute_id ) ) {
                        $attributes[ $key ]['id'] = $attribute_id;
                        continue;
                    }
                }
            }

            return $attributes;
        }

        /**
         * Add terms without ID to terms array.
         *
         * @param  array  $terms    Request object value for term.
         * @param  string $taxonomy Taxonomy we are searching.
         * @return array
         */
        private function search_terms_without_id( $terms, $taxonomy ) {
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

            return $terms;
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
            return apply_filters( 'aifw_api_v3_products_term_not_found', 0, $params, $taxonomy );
        }
    }

}
