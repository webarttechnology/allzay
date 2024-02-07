<?php
/**
 * https://woo.com/documentation/products/extensions/all-products-for-woocommerce-subscriptions/
 */

namespace FKCart\Compatibilities;
class AllProductSubscriptions {
	public function __construct() {
		add_action( 'fkcart_before_add_to_cart', [ $this, 'remove_subscription_action' ] );
	}

	public function is_enable() {
		return class_exists( 'WCS_ATT_Cart' );
	}

	public function remove_subscription_action() {
		if ( isset( $_REQUEST['subscribe-to-action-input'] ) && 'no' === $_REQUEST['subscribe-to-action-input'] ) {
			remove_filter( 'woocommerce_add_cart_item_data', array( 'WCS_ATT_Cart', 'add_cart_item_data' ), 10 );
		}
	}
}

Compatibility::register( new AllProductSubscriptions(), 'allproductsubscriptions' );
