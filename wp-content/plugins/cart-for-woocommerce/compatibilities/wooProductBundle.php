<?php
/**
 * WPC Product Bundles for WooCommerce
 * By WPClever
 */

namespace FKCart\Compatibilities;
class WooProductBundle {
	public function __construct() {
		add_filter( 'fkcart_cart_item_is_sold_individually', [ $this, 'is_child_product' ], 10, 2 );
		add_filter( 'fkcart_item_hide_delete_icon', [ $this, 'is_child_product' ], 10, 2 );
	}

	public function is_enable() {
		return defined( 'WOOSB_DIR' );
	}

	public function is_child_product( $status, $cart_item ) {
		if ( isset( $cart_item['woosb_ids'] ) ) {
			return false;
		}

		return isset( $cart_item['woosb_parent_id'] ) ? true : $status;
	}
}

Compatibility::register( new WooProductBundle(), 'WooProductBundle' );
