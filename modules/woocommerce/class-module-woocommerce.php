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

            if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '9.5', '<' ) ) {
                $notice = __( 'Please update <strong>WooCommerce</strong>. The minimum supported version for <strong>API Improver for WooCommerce</strong> is 4.5.', AIFW_TEXTDOMAIN );
                $module->add_dependence_notice( $notice );
            }

            $this->includes = array(
                'api/class-hook-base',
                'api/v1/class-products',
            );
        }

        /**
         * Define hooks
         *
         * @since    1.0.0
         * @param    API_Improver_For_WooCommerce      $core   The Core object
         */
        public function define_hooks() {
            AIFW_Api_V1_Products::filter( 'woocommerce_rest_product_schema' );
            AIFW_Api_V1_Products::filter( 'woocommerce_rest_pre_insert_product_object', 2 );
        }

    }

}

