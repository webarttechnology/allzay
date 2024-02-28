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
}

Compatibility::register( new Woomulticurrency(), 'woomulticurrency' );
