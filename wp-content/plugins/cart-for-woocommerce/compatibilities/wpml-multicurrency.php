<?php

namespace FKCart\compatibilities;
class WPML_Multicurrency {
	public function __construct() {
		add_action( 'woocommerce_calculate_totals', [ $this, 'attach_actions' ], 100 );
	}

	public function attach_actions() {
		if ( $this->is_enable() && class_exists( 'FKCart\Pro\Rewards' ) ) {
			remove_action( 'woocommerce_calculate_totals', [ $this, 'attach_actions' ], 100 );
			$instance = \FKCart\Pro\Rewards::getInstance();
			$instance->update_reward();
		}
	}

	public function is_enable() {
		global $woocommerce_wpml;

		return ( class_exists( '\woocommerce_wpml' ) && $woocommerce_wpml instanceof \woocommerce_wpml );
	}

	/**
	 *
	 * Modifies the amount for the fixed discount given by the admin in the currency selected.
	 *
	 * @param integer|float $price
	 *
	 * @return float
	 */
	public function alter_fixed_amount( $price, $currency = null ) {
		if ( ! class_exists( '\SitePress' ) ) {
			return $price;
		}

		global $woocommerce_wpml;
		if ( WCML_MULTI_CURRENCIES_INDEPENDENT !== $woocommerce_wpml->settings['enable_multi_currency'] ) {
			return $price;
		}

		return $woocommerce_wpml->get_multi_currency()->prices->convert_price_amount( $price );
	}

	function get_fixed_currency_price_reverse( $price, $from = null, $base = null ) {
		if ( ! class_exists( '\SitePress' ) ) {
			return $price;
		}
		global $woocommerce_wpml;
		if ( WCML_MULTI_CURRENCIES_INDEPENDENT !== $woocommerce_wpml->settings['enable_multi_currency'] ) {
			return $price;
		}

		return $woocommerce_wpml->get_multi_currency()->prices->unconvert_price_amount( $price, $from );
	}
}

Compatibility::register( new WPML_Multicurrency(), 'woowpmlmulticurrency' );
