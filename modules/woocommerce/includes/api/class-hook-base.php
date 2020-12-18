<?php

/**
 * WAI_Hook_Base
 * Help create another filters
 *
 * @package         Woo_API_Improver
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'WAI_Hook_Base' ) ) {

    class WAI_Hook_Base {

        /**
         * Class instance.
         *
         * @var WAI_Hook_Base child instance
         */
        protected static $instance = false;

        /**
         * Get class instance
         */
        public static function get_instance() {
            if ( ! static::$instance ) {
                static::$instance = new static();
            }

            return static::$instance;
        }

        /**
         * Register a filter
         *
         * @param  string  $hook
         * @param  integer $args
         * @param  integer $priority
         *
         * @return void
         */
        public static function filter( $hook, $args = 1, $priority = 20 ) {
            $instance = self::get_instance();
            $method = 'filter_' . $hook;

            $core = Woo_API_Improver::instance();
            $core->add_filter( $hook, array( $instance, $method ), $priority, $args );
        }

        /**
         * Register a action
         *
         * @param  string  $hook
         * @param  integer $args
         * @param  integer $priority
         *
         * @return void
         */
        public static function action( $hook, $args = 1, $priority = 20 ) {
            $instance = self::get_instance();
            $method = 'action_' . $hook;

            $core = Woo_API_Improver::instance();
            $core->add_action( $hook, array( $instance, $method ), $priority, $args );
        }

    }

}
