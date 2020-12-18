<?php

/**
 * WAI_Module_Woocommerce
 * Class responsible to manage all WooCommerce stuff
 *
 * Depends: dependence
 *
 * @package         Woo_API_Improver
 * @subpackage      WAI_Module_Woocommerce
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'WAI_Module_Woocommerce' ) ) {

    class WAI_Module_Woocommerce {

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
                $notice = __( 'Please update <strong>WooCommerce</strong>. The minimum supported version for <strong>API Improver for WooCommerce</strong> is 4.5.', WAI_TEXTDOMAIN );
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
         * @param    Woo_API_Improver      $core   The Core object
         */
        public function define_hooks() {
            WAI_Api_V1_Products::filter( 'woocommerce_rest_product_schema' );
            WAI_Api_V1_Products::filter( 'woocommerce_rest_pre_insert_product_object', 2 );
        }

    }

}

