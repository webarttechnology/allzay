<?php
/**
 * CURCY - Multi Currency for WooCommerce
 *  https://villatheme.com/extensions/woo-multi-currency/
 */

namespace FKCart\Compatibilities;
class Woomulticurrency {

	public function is_enable() {
		return defined( 'WOOMULTI_CURRENCY_F_VERSION' );
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
		return \wmc_get_price( $price, $currency );
	}

	public function get_fixed_currency_price_reverse( $price, $from = null, $base = null ) {
		$data = new \WOOMULTI_CURRENCY_F_Data();
		$from = ( is_null( $from ) ) ? $data->get_current_currency() : $from;
		$base = ( is_null( $base ) ) ? get_option( 'woocommerce_currency' ) : $base;

		$rates = $data->get_exchange( $from, $base );
		if ( is_array( $rates ) && isset( $rates[ $base ] ) ) {
			$price = $price * $rates[ $base ];
		}

		return $price;
	}
}

Compatibility::register( new Woomulticurrency(), 'woomulticurrency' );
