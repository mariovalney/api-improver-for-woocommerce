<?php

/**
 * AIFW_Module_Woocommerce
 * Class responsible to manage all WooCommerce stuff
 *
 * Depends: dependence
 *
 * @package         API_Improver_For_WooCommerce
 * @subpackage      AIFW_Module_Woocommerce
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'AIFW_Module_Woocommerce' ) ) {

    class AIFW_Module_Woocommerce {

        /**
         * Run
         *
         * @since    1.0.0
         */
        public function run() {
            $module = $this->core->get_module( 'dependence' );

            // Checking Dependences
            $module->add_dependence( 'woocommerce/woocommerce.php', 'WooCommerce', 'woocommerce' );

            if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '4.5', '<' ) ) {
                $notice = __( 'Please update <strong>WooCommerce</strong>. The minimum supported version for <strong>API Improver for WooCommerce</strong> is 4.5.', 'api-improver-for-woocommerce' );
                $module->add_dependence_notice( $notice );
            }

            $this->includes = array(
                'api/v3/class-products',
            );
        }

        /**
         * Define hooks
         *
         * @since    1.0.0
         * @param    API_Improver_For_WooCommerce      $core   The Core object
         */
        public function define_hooks() {
            $this->core->add_filter( 'woocommerce_rest_api_get_rest_namespaces', array( $this, 'woocommerce_rest_api_get_rest_namespaces' ), 10, 1 );
        }

        /**
         * Filter: 'woocommerce_rest_api_get_rest_namespaces'
         *
         * @see wp-content/plugins/woocommerce/includes/rest-api/Server.php:53
         * @return array
         */
        public function woocommerce_rest_api_get_rest_namespaces( $namespaces ) {
            $v3_controllers = array(
                'products' => 'AIFW_Api_V3_Products_Controller',
            );

            if ( ! empty( $namespaces['wc/v3'] ) ) {
                $namespaces['wc/v3'] = array_merge( $namespaces['wc/v3'], $v3_controllers );
            }

            return $namespaces;
        }

    }

}

