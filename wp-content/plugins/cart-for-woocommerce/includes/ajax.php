<?php

namespace FKCart\Includes;

use FKCart\Includes\Traits\Instance;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ajax {

	use Instance;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'get_fragments' ], 99 );;
		add_action( 'wp', [ $this, 'set_fkcart_cookies' ], 20 );
		$this->handle_public_ajax();
	}

	/**
	 * Attach fragments on add to cart
	 *
	 * @param $fragments
	 *
	 * @return mixed
	 */
	public function get_fragments( $fragments ) {
		$this->set_cookie();
		$fragments['.fkcart-modal-container'] = fkcart_get_active_skin_html();
		$fragments['.fkcart-mini-toggler']    = fkcart_mini_cart_html();

		return $fragments;
	}

	public function handle_public_ajax() {
		$endpoints = self::get_available_public_endpoints();
		foreach ( $endpoints as $action => $function ) {
			add_action( 'wc_ajax_' . $action, [ $this, $function ] );
		}
	}

	/**
	 * Get WC public endpoints
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public static function get_public_endpoints( $query = [] ) {
		$public_endpoints = self::get_available_public_endpoints();
		if ( empty( $public_endpoints ) || ! is_array( $public_endpoints ) ) {
			return [];
		}

		$endpoints = [];
		foreach ( $public_endpoints as $key => $function ) {
			$url = \WC_AJAX::get_endpoint( $key );
			$url = is_array( $query ) && count( $query ) > 0 ? add_query_arg( $query, $url ) : $url;

			$endpoints[ $key ] = $url;
		}

		return $endpoints;
	}

	/**
	 * Get wc ajax endpoints names
	 *
	 * @return string[]
	 */
	public static function get_available_public_endpoints() {
		return [
			'fkcart_get_slide_cart'    => 'fragments',
			'fkcart_add_item'          => 'add_cart_item',
			'fkcart_update_item'       => 'update_cart_item',
			'fkcart_remove_item'       => 'remove_cart_item',
			'fkcart_apply_coupon'      => 'apply_coupon',
			'fkcart_remove_coupon'     => 'remove_coupon',
			'fkcart_quick_view'        => 'item_quick_view',
			'fkcart_update_attributes' => 'update_variable_item_attributes',
		];
	}

	/**
	 * Triggers when item is added to the cart
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function add_cart_item() {

		$product_id    = isset( $_POST['fkcart_product_id'] ) ? sanitize_text_field( $_POST['fkcart_product_id'] ) : '';
		$variation_id  = isset( $_POST['fkcart_variation_id'] ) ? sanitize_text_field( $_POST['fkcart_variation_id'] ) : '';
		$quantity      = isset( $_POST['fkcart_quantity'] ) ? sanitize_text_field( $_POST['fkcart_quantity'] ) : 1;
		$attributes    = isset( $_POST['attributes'] ) ? ( $_POST['attributes'] ) : [];
		$cart_item_key = isset( $_POST['fkcart-cart-key'] ) ? sanitize_text_field( $_POST['fkcart-cart-key'] ) : '';

		if ( ! empty( $cart_item_key ) ) {
			$this->update_variable_item_attributes();

			return;
		}

		$variation_id = ! is_null( $variation_id ) ? $variation_id : 0;

		$fkcart_single_product_add_to_cart = isset( $_POST['fkcart_single_product_add_to_cart'] );

		if ( empty( $product_id ) || empty( $quantity ) || ! is_numeric( $product_id ) || ! is_numeric( $quantity ) ) {
			$this->error_response();
		}

		$product_id = intval( $product_id );
		$quantity   = intval( $quantity );

		if ( is_null( WC()->cart ) ) {
			$this->error_response( __( 'Cart not defined', 'cart-for-woocommerce' ) );
		}

		$product = wc_get_product( $product_id );
		$error   = false;

		$cart_item_data = ! $fkcart_single_product_add_to_cart ? [ '_fkcart_upsell' => 'yes' ] : [];

		/** prevent internal redirection during the ajax call */
		add_filter( 'wp_redirect', '__return_false', 100 );

		do_action( 'fkcart_before_add_to_cart', $product_id, $quantity, $variation_id, $attributes, $cart_item_data );

		$cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $attributes, $cart_item_data );
		if ( $cart_item_key ) {
			$message = sprintf( __( '"%s" has been added to the cart.', 'cart-for-woocommerce' ), $product->get_name() );
			do_action( 'fkcart_after_add_to_cart', $cart_item_key, $product_id, $quantity, $variation_id, $attributes, $cart_item_data );
			do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		} else {
			$error   = true;
			$message = sprintf( __( 'Unable to add "%s" to the cart', 'cart-for-woocommerce' ), $product->get_name() );
		}

		if ( true === $error ) {
			$this->error_response( $message );
		}
		$this->send_success();
	}

	/**
	 * Update variable item
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function update_variable_item_attributes() {
		$product_id    = isset( $_POST['fkcart_product_id'] ) ? sanitize_text_field( $_POST['fkcart_product_id'] ) : '';
		$variation_id  = isset( $_POST['fkcart_variation_id'] ) ? sanitize_text_field( $_POST['fkcart_variation_id'] ) : '';
		$quantity      = isset( $_POST['fkcart_quantity'] ) ? sanitize_text_field( $_POST['fkcart_quantity'] ) : 1;
		$attributes    = isset( $_POST['attributes'] ) ? ( $_POST['attributes'] ) : [];
		$cart_item_key = isset( $_POST['fkcart-cart-key'] ) ? sanitize_text_field( $_POST['fkcart-cart-key'] ) : '';

		if ( empty( $product_id ) || empty( $quantity ) || ! is_numeric( $product_id ) || ! is_numeric( $quantity ) ) {
			$this->error_response();
		}

		$product_id = intval( $product_id );
		$quantity   = intval( $quantity );
		if ( is_null( WC()->cart ) ) {
			$this->error_response( __( 'Cart not defined', 'cart-for-woocommerce' ) );
		}

		$cart_item_data = [];
		if ( ! empty( $cart_item_key ) ) {
			$cart_item = WC()->cart->get_cart_item( $cart_item_key );

			if ( isset( $cart_item['_fkcart_free_gift'] ) ) {
				$cart_item_data = [ '_fkcart_free_gift' => 1 ];
			}
		}
		$error = false;

		add_filter( 'wp_redirect', '__return_false', 100 );
		do_action( 'fkcart_variable_product_before_update' );

		WC()->cart->remove_cart_item( $cart_item_key );

		do_action( 'fkcart_before_add_to_cart', $product_id, $quantity, $variation_id, $attributes, $cart_item_data );
		$new_item_key = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $attributes, $cart_item_data );
		do_action( 'fkcart_variable_product_after_update' );

		if ( $new_item_key ) {
			do_action( 'fkcart_added_add_to_cart', $new_item_key, $product_id, $quantity, $variation_id, $attributes, $cart_item_data );
			do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		} else {
			$error = true;
		}
		if ( true === $error ) {
			$this->error_response();
		}
		$this->send_success();
	}

	/**
	 * Update cart item
	 *
	 * @return void
	 */
	public function update_cart_item() {

		$cart_key = isset( $_POST['cart_key'] ) ? sanitize_text_field( $_POST['cart_key'] ) : '';
		if ( empty( $cart_key ) ) {
			$this->error_response();
		}

		if ( is_null( WC()->cart ) ) {
			$this->error_response( __( 'Cart not defined', 'cart-for-woocommerce' ) );
		}

		$cart_items = WC()->cart->get_cart();
		if ( ! isset( $cart_items[ $cart_key ] ) ) {
			$this->error_response( __( 'Cart item not found', 'cart-for-woocommerce' ) );
		}

		$cart_item = $cart_items[ $cart_key ];
		$product   = $cart_item['data'];
		/** @var $product \WC_Product; */

		/** Prevent internal redirection during the ajax call */
		add_filter( 'wp_redirect', '__return_false', 100 );

		$quantity = isset( $_POST['quantity'] ) ? sanitize_text_field( $_POST['quantity'] ) : '';
		$quantity = empty( $quantity ) ? 0 : floatval( $quantity );

		/** If 0 qty set */
		if ( 0 == $quantity || $quantity < 0 ) {
			WC()->cart->remove_cart_item( $cart_key );
			$message = sprintf( __( '%s has been removed from your cart.', 'woocommerce' ), $product->get_name() );
			$this->send_success( $message );
		}

		if ( ! $product->has_enough_stock( $quantity ) ) {
			$message = sprintf( __( 'Sorry, you can not add more then %s of "%s". Please edit your cart and try again.', 'cart-for-woocommerce' ), $product->get_stock_quantity(), $product->get_name() );
			$this->error_response( $message );
		}

		$status = WC()->cart->set_quantity( $cart_key, $quantity );
		if ( $status ) {
			$message = sprintf( __( '"%s" has been updated.', 'cart-for-woocommerce' ), $product->get_name() );
			$this->send_success( $message );
		}

		$product_qty_in_cart      = WC()->cart->get_cart_item_quantities();
		$current_session_order_id = ( isset( WC()->session->order_awaiting_payment ) ? absint( WC()->session->order_awaiting_payment ) : 0 );

		$held_stock     = wc_get_held_stock_quantity( $product, $current_session_order_id );
		$required_stock = $product_qty_in_cart[ $product->get_stock_managed_by_id() ];
		if ( $product->get_stock_quantity() < ( $held_stock + $required_stock ) ) {
			$message = sprintf( __( 'Sorry, we do not have enough "%1$s" in stock to fulfill your order (%2$s available). We apologize for any inconvenience caused.', 'woocommerce' ), $product->get_name(), wc_format_stock_quantity_for_display( $product->get_stock_quantity() - $held_stock, $product ) );
			$this->error_response( $message );
		}

		$message = sprintf( __( 'Some error occurred in updating the "%s"', 'cart-for-woocommerce' ), $product->get_name() );
		$this->error_response( $message );
	}

	/**
	 * Remove cart item
	 *
	 * @return void
	 */
	public function remove_cart_item() {

		$cart_key = isset( $_POST['cart_key'] ) ? sanitize_text_field( $_POST['cart_key'] ) : '';
		if ( empty( $cart_key ) ) {
			$this->error_response( __( 'Cart item not found', 'cart-for-woocommerce' ) );
		}

		if ( is_null( WC()->cart ) ) {
			$this->error_response( __( 'Cart not defined', 'cart-for-woocommerce' ) );
		}

		$cart_item = WC()->cart->get_cart_item( $cart_key );
		if ( empty( $cart_item ) ) {
			$this->error_response( __( 'Cart item not found', 'cart-for-woocommerce' ) );
		}

		$product      = $cart_item['data'];
		$product_name = $product->get_name();

		/** Removing cart item */
		WC()->cart->remove_cart_item( $cart_key );

		$message = sprintf( __( '"%s" is removed', 'cart-for-woocommerce' ), $product_name );
		$this->send_success( $message );
	}

	/**
	 * Apply coupon
	 *
	 * @return void
	 */
	public function apply_coupon() {

		if ( is_null( WC()->cart ) ) {
			$this->error_response( __( 'Cart not defined', 'cart-for-woocommerce' ) );
		}

		wc_clear_notices();

		$coupon_code = isset( $_POST['discount_code'] ) ? sanitize_text_field( $_POST['discount_code'] ) : '';
		if ( ! empty( $coupon_code ) ) {
			WC()->cart->add_discount( wc_format_coupon_code( $coupon_code ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		} else {
			$this->error_response( \WC_Coupon::get_generic_coupon_error( \WC_Coupon::E_WC_COUPON_PLEASE_ENTER ) );
		}

		$error = wc_get_notices( 'error' );

		ob_start();
		wc_print_notices();
		$messages = ob_get_clean();
		$messages = strip_tags( $messages, '<span>' );

		if ( count( $error ) > 0 ) {
			$this->error_response( $messages );
		}

		$this->send_success( $messages );
	}

	/**
	 * Remove coupon
	 *
	 * @return void
	 */
	public function remove_coupon() {

		$coupon_code = isset( $_POST['discount_code'] ) ? sanitize_text_field( $_POST['discount_code'] ) : '';
		if ( is_null( WC()->cart ) ) {
			$this->error_response( __( 'Cart not defined', 'cart-for-woocommerce' ) );
		}

		wc_clear_notices();
		if ( ! empty( $coupon_code ) ) {
			WC()->cart->remove_coupon( $coupon_code );
		}

		$error = wc_get_notices( 'error' );

		ob_start();
		wc_print_notices();
		$messages = ob_get_clean();
		$messages = strip_tags( $messages );
		if ( count( $error ) > 0 ) {
			$this->error_response( strip_tags( $messages ) );
		}

		$this->send_success( $messages );
	}

	/**
	 * Return quick view HTML
	 *
	 * @return void
	 */
	public function item_quick_view() {

		$cart_key     = isset( $_POST['cart_key'] ) ? sanitize_text_field( $_POST['cart_key'] ) : '';
		$product_id   = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';
		$variation_id = '';
		if ( ! empty( $cart_key ) ) {
			$item = WC()->cart->get_cart_item( $cart_key );
			if ( empty( $item ) ) {
				$this->error_response();
			}
			$product_id   = $item['product_id'];
			$variation_id = $item['product_id'];
		}
		if ( is_null( $product_id ) || empty( $product_id ) ) {
			$this->error_response();
		}

		$product_id = intval( $product_id );

		/** wp_query for the product */
		wp( 'p=' . $product_id . '&post_type=product' );

		global $product;
		$product    = wc_get_product( $product_id );
		$quick_view = Quickview::get_instance();
		$quick_view->set_product_data( $product, $variation_id, $cart_key );
		ob_start();

		fkcart_get_template_part( 'cart/quick-view/content', '', [ 'product' => $product, 'variation_id' => $variation_id, 'product_id' => $product_id, 'cart_key' => $cart_key ] );

		$output = ob_get_clean();

		wp_send_json( array(
			'quick_view_content' => $output,
			'code'               => 200
		) );
	}

	/**
	 * Attach cart skin fragment
	 *
	 * @param $message
	 *
	 * @return void
	 */
	public function fragments( $message = '' ) {
		wc_maybe_define_constant( 'WOOCOMMERCE_CART', true );
		$this->set_cookie();


		$need_re_run_slide_cart = DATA::need_re_run_get_slide_cart_ajax() && ( did_action( 'wc_ajax_fkcart_add_item' ) > 0 || did_action( 'wc_ajax_fkcart_update_item' ) > 0 || did_action( 'wc_ajax_fkcart_remove_item' ) > 0 );
		$fragments              = [];
		if ( ! $need_re_run_slide_cart ) {
			$fragments['.fkcart-modal-container'] = fkcart_get_active_skin_html();
			$fragments['.fkcart-mini-toggler']    = fkcart_mini_cart_html();
		}
		$resp = [
			'fragments'                => apply_filters( 'fkcart_fragments', $fragments ),
			'ajax_nonce'               => wp_create_nonce( 'fkcart' ),
			'fkcart_re_run_slide_cart' => $need_re_run_slide_cart ? 'yes' : 'no',
			'cart_hash'                => WC()->cart->get_cart_hash(),
			'code'                     => 200,
			'status'                   => true,
		];
		if ( ! empty( $resp ) ) {
			$resp['message'] = $message;
		}
		wp_send_json( $resp );
	}

	/**
	 * Verify nonce
	 *
	 * @return void
	 */
	protected function verify_nonce() {
		$nonce = filter_input( INPUT_POST, 'nonce', FILTER_UNSAFE_RAW );
		if ( is_null( $nonce ) || ! wp_verify_nonce( $nonce, 'fkcart' ) ) {
			wp_send_json( array(
				'msg'  => __( 'Security check failed', 'cart-for-woocommerce' ),
				'code' => 401
			) );
		}
	}

	/**
	 * Send success response on ajax callbacks
	 *
	 * @param $message
	 *
	 * @return void
	 */
	protected function send_success( $message = '' ) {
		do_action( 'woocommerce_check_cart_items' );
		if ( ! is_null( WC()->cart ) ) {
			WC()->cart->calculate_totals(); // run calculate in every ajax call for proper total calculation
		}
		$this->fragments( $message );
	}

	/**
	 * Send error response on ajax callbacks
	 *
	 * @param $msg
	 *
	 * @return void
	 */
	protected function error_response( $msg = '' ) {
		$this->set_cookie();
		wp_send_json( array(
			'msg'  => empty( $msg ) ? __( 'Required data missing', 'cart-for-woocommerce' ) : $msg,
			'code' => 400
		) );
	}

	/**
	 * Set cookie
	 *
	 * @return void
	 */
	protected function set_cookie() {
		$instance   = Front::get_instance();
		$cart_count = $instance->get_cart_content_count();

		$cookie_names = Data::fkcart_frontend_cookie_names();

		wc_setcookie( $cookie_names['quantity'], $cart_count, time() + ( MINUTE_IN_SECONDS * 30 ), false, false );
		wc_setcookie( $cookie_names['cart_total'], $instance->get_subtotal(), time() + ( MINUTE_IN_SECONDS * 30 ), false, false );
	}

	/**
	 * Public method to set cookie at wp hooks sometime quantity mismatch with actual cart quantity
	 *
	 * @return void
	 */
	public function set_fkcart_cookies() {
		if ( is_null( WC()->cart ) || headers_sent() ) { // do not set cookie if headers already sent
			return;
		}
		$this->set_cookie();
	}
}
