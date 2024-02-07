<?php
/**
 * WooCommerce Chained Products
 * by StoreApps
 */

namespace FKCart\Compatibilities;
class Chained {
	public function __construct() {
		add_filter( 'fkcart_cart_item_is_sold_individually', [ $this, 'is_child_product' ], 10, 2 );
		add_filter( 'fkcart_item_hide_delete_icon', [ $this, 'is_child_product' ], 10, 2 );
	}

	public function is_enable() {
		return defined( 'WC_CP_PLUGIN_DIRNAME' );
	}

	public function is_child_product( $status, $cart_item ) {
		return isset( $cart_item['chained_item_of'] ) ? true : $status;
	}
}

Compatibility::register( new Chained(), 'chained' );
