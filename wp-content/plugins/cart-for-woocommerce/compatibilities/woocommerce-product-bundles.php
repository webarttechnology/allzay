<?php
/**
 * WooCommerce Product Bundles
 * By WooCommerce
 */

namespace FKCart\Compatibilities;
class WooCommerceProductBundles {

	public $bundle_data = [];

	public function __construct() {
		add_filter( 'fkcart_cart_item_is_sold_individually', [ $this, 'is_child_product' ], 10, 2 );
		add_filter( 'fkcart_item_hide_delete_icon', [ $this, 'is_delete_child_product' ], 10, 2 );
	}

	public function is_enable() {
		return class_exists( 'WC_Bundles' );
	}

	public function is_child_product( $status, $cart_item ) {
		if ( ! isset( $cart_item['bundled_by'] ) ) {
			return $status;
		}

		if ( isset( $this->bundle_data[ $cart_item['bundled_by'] ] ) ) {
			$bundle = $this->bundle_data[ $cart_item['bundled_by'] ];
		} else {
			$cart_contents = WC()->cart->get_cart_contents();
			if ( ! isset( $cart_contents[ $cart_item['bundled_by'] ] ) ) {
				return $status;
			}
			$bundle = $cart_contents[ $cart_item['bundled_by'] ]['data'];

			$this->bundle_data[ $cart_item['bundled_by'] ] = $bundle;
		}
		if ( ! $bundle instanceof WC_Product_Bundle ) {
			return $status;
		}

		$bundled_item = $bundle->get_bundled_item( $cart_item['bundled_item_id'] );
		if ( ! $bundled_item instanceof WC_Bundled_Item ) {
			return $status;
		}

		$maybe_visible_bundled_item = $bundle->get_bundled_item( $cart_item['bundled_item_id'] );
		if ( ! is_a( $maybe_visible_bundled_item, 'WC_Bundled_Item' ) ) {
			return $status;
		}

		return $maybe_visible_bundled_item->is_visible( 'cart' );
	}

	public function is_delete_child_product( $status, $cart_item ) {
		if ( isset( $cart_item['bundled_items'] ) ) {
			return false;
		}

		if ( ! isset( $cart_item['bundled_by'] ) ) {
			return $status;
		}

		return true;
	}
}

Compatibility::register( new WooCommerceProductBundles(), 'woocommerce-product-bundles' );
