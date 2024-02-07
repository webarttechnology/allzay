<?php

namespace FKCart\Compatibilities;
/**
 * Class Loader
 * Loads all the compatibilities files we have to provide compatibility with each plugin
 */
class Compatibility {

	private static $plugin_compatibilities = array();

	public static function load() {
		self::after_plugins_loaded_compatibilities();

		add_action( 'after_setup_theme', [ __CLASS__, 'after_setup_theme_compatibilities' ] );
	}

	/**
	 * Load compatibilities after plugins loaded
	 *
	 * @return void
	 */
	public static function after_plugins_loaded_compatibilities() {
		$files = [
			'adp.php'                         => defined( 'WC_ADP_PLUGIN_FILE' ),
			'aelia.php'                       => class_exists( '\Aelia\WC\CurrencySwitcher\WC_Aelia_CurrencySwitcher' ),
			'bump.php'                        => class_exists( '\WFOB_Core' ),
			'chained.php'                     => defined( 'WC_CP_PLUGIN_DIRNAME' ),
			'checkoutpluginstripe.php'        => class_exists( '\CPSW\Inc\Helper' ),
			'freeshipping.php'                => class_exists( '\FKCart\Pro\Plugin' ),
			'funnelkitstripe.php'             => class_exists( '\FKWCS_Gateway_Stripe' ),
			'paymentpluginbraintree.php'      => defined( 'WC_BRAINTREE_PATH' ),
			'paymentpluginstripe.php'         => class_exists( '\WC_Stripe_Manager' ),
			'tablerate.php'                   => class_exists( '\WC_Table_Rate_Shipping' ),
			'wcrewardpoints.php'              => class_exists( '\WC_Points_Rewards' ),
			'wcstripe.php'                    => function_exists( 'woocommerce_gateway_stripe' ),
			'woocommerce-product-bundles.php' => class_exists( '\WC_Bundles' ),
			'woocs.php'                       => class_exists( '\WOOCS' ),
			'woomulticurrency.php'            => defined( 'WOOMULTI_CURRENCY_F_VERSION' ),
			'wooProductBundle.php'            => defined( 'WOOSB_DIR' ),
			'wpml-multicurrency.php'          => class_exists( '\SitePress' ),
			'litespeed.php'                   => defined( 'LSCWP_V' ),
			'klarna.php'                      => class_exists( '\WC_Klarna_Payments' ) && defined( 'WFFN_PRO_FILE' ),
			'funnelkitcheckout.php'           => class_exists( '\WFACP_Core' ),
		];

		self::add_files( $files );
	}

	/**
	 * Load compatibilities after setup theme
	 *
	 * @return void
	 */
	public static function after_setup_theme_compatibilities() {
		$files = [
			'astra.php'                   => defined( 'ASTRA_THEME_VERSION' ),
			'shoptimizer.php'             => function_exists( 'shoptimizer_header_cart' ),
			'smartcoupons.php'            => class_exists( '\WC_Smart_Coupons' ),
			'allproductsubscriptions.php' => class_exists( 'WCS_ATT_Cart' ),
		];

		self::add_files( $files );
	}

	public static function add_files( $paths ) {
		try {
			foreach ( $paths as $file => $condition ) {
				if ( false === $condition ) {
					continue;
				}
				include_once __DIR__ . '/' . $file;
			}
		} catch ( \Exception $e ) {

		}
	}

	public static function register( $object, $slug ) {
		self::$plugin_compatibilities[ $slug ] = $object;
	}

	public static function get_compatibility_class( $slug ) {
		return ( isset( self::$plugin_compatibilities[ $slug ] ) ) ? self::$plugin_compatibilities[ $slug ] : false;
	}

	public static function remove_smart_buttons() {
		if ( empty( self::$plugin_compatibilities ) ) {
			return '';
		}
		foreach ( self::$plugin_compatibilities as $plugins_class ) {
			if ( method_exists( $plugins_class, 'is_enable' ) && $plugins_class->is_enable() && is_callable( array( $plugins_class, 'remove_smart_buttons' ) ) ) {
				return call_user_func( array( $plugins_class, 'remove_smart_buttons' ) );
			}
		}
	}

	public static function get_free_shipping( \WC_Shipping_Method $shipping_instance ) {
		if ( empty( self::$plugin_compatibilities ) || ! isset( self::$plugin_compatibilities[ $shipping_instance->id ] ) ) {
			return false;
		}
		$instance = self::$plugin_compatibilities[ $shipping_instance->id ];

		return $instance->get_free_shipping( $shipping_instance );
	}

	public static function get_fixed_currency_price( $price, $currency = null ) {
		if ( empty( self::$plugin_compatibilities ) ) {
			return $price;
		}

		foreach ( self::$plugin_compatibilities as $plugins_class ) {
			if ( method_exists( $plugins_class, 'is_enable' ) && $plugins_class->is_enable() && is_callable( array( $plugins_class, 'alter_fixed_amount' ) ) ) {
				return call_user_func( array( $plugins_class, 'alter_fixed_amount' ), $price, $currency );
			}
		}

		return $price;
	}

	public static function get_fixed_currency_price_reverse( $price, $from = null, $to = null ) {
		if ( empty( self::$plugin_compatibilities ) ) {
			return $price;
		}

		foreach ( self::$plugin_compatibilities as $plugins_class ) {
			if ( method_exists( $plugins_class, 'is_enable' ) && $plugins_class->is_enable() && is_callable( array( $plugins_class, 'get_fixed_currency_price_reverse' ) ) ) {
				return call_user_func( array( $plugins_class, 'get_fixed_currency_price_reverse' ), $price, $from, $to );
			}
		}

		return $price;
	}
}
