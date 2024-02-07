<?php

namespace FKCart\Compatibilities;
class Klarna {
	public function __construct() {
		add_action( 'woocommerce_checkout_process', [ $this, 'remove_reward_code' ] );
	}

	public function is_enable() {
		return class_exists( '\WC_Klarna_Payments' ) && defined( 'WFFN_PRO_FILE' );
	}

	/**
	 * unhook update reward callback during the checkout process because of klarna throw the mismatch cart quantity.
	 * @return void
	 */
	public function remove_reward_code() {
		if ( ! class_exists( '\FKCart\Pro\Rewards' ) ) {
			return;
		}
		remove_action( 'woocommerce_calculate_totals', [ \FKCart\Pro\Rewards::getInstance(), 'update_reward' ], 99 );
	}

}

Compatibility::register( new Klarna(), 'Klarna' );
