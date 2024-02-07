<?php

namespace FKCart\Includes;

use FKCart\Includes\Traits\Instance;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Front {

	use Instance;

	private $add_to_cart_trigger = false;
	private $preview_discount = 20;
	private $drawer_displayed = false;

	/**
	 * Class constructor
	 */
	private function __construct() {
		add_action( 'woocommerce_add_to_cart', [ $this, 'add_to_cart_trigger' ], - 10 );
		add_action( 'wp', [ $this, 'init_hooks' ] );
		add_filter( 'fkcart_admin_ajax_args', [ $this, 'append_ajax_parameter' ] );

		/** Disable redirect to cart after adding product */
		add_filter( 'pre_option_woocommerce_cart_redirect_after_add', [ $this, 'disable_woocommerce_cart_redirect_after_add' ] );

		/** Enable ajax on add to cart product */
		add_filter( 'pre_option_woocommerce_enable_ajax_add_to_cart', [ $this, 'enable_woocommerce_enable_ajax_add_to_cart' ] );
		add_action( 'after_setup_theme', [ $this, 'register_shortcode' ] );
	}

	/**
	 * Initialize hooks after theme setup
	 *
	 * @return void
	 */
	public function init_hooks() {
		/** Prevent Below Code execution when rest api call running */
		if ( $this->is_rest_call() ) {
			return;
		}

		if ( is_admin() ) {
			return;
		}

		if ( false === Data::is_cart_enabled( 'all' ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', [ $this, 'load_cart_assets' ], 13 );
		add_action( 'wp_footer', [ $this, 'cart_icon' ], 20 );
		add_action( 'wp_footer', [ $this, 'cart_content' ], 21 );
		add_filter( 'fkcart_fragments', [ $this, 'button_icon_fragments' ] );
		add_filter( 'wp_nav_menu_items', [ $this, 'append_cart_link' ], 99, 2 );
		add_action( 'wp_footer', [ $this, 'handleCartFlickering' ], 21 );

		/** @todo remove below action in Mar month */
		add_filter( 'fkwcs_express_button_selected_location', [ $this, 'enqueue_smart_button_javascript' ] );

		add_filter( 'fkwcs_enqueue_express_button_assets', [ $this, 'enqueue_smart_button_javascript' ] );
	}

	/**
	 * Check if a wc rest call
	 *
	 * @return bool
	 */
	public function is_rest_call() {
		return ( function_exists( 'WC' ) && WC()->is_rest_api_request() );
	}

	/**
	 * Load JS & CSS assets
	 *
	 * @return void
	 */
	public function load_cart_assets() {
		/** Return if display disabled */
		if ( Data::is_display_disabled() ) {
			return;
		}
		Data::load_cart_assets();
		$custom_css = Data::get_value( 'custom_css' );
		if ( ! empty( $custom_css ) ) {
			wp_add_inline_style( 'fkcart-style', $custom_css );
		}
		wp_localize_script( 'fkcart-script', 'fkcart_app_data', $this->localize_data() );
		wp_enqueue_script( 'wc-single-product' );
		wp_enqueue_script( 'wc-add-to-cart-variation' );

		/**
		 * @todo Need to Remove below code in Future version by Jun 2024
		 */
		if ( Data::is_smart_button_enabled() && defined( 'FKWCS_VERSION' ) && version_compare( '1.4.1', FKWCS_VERSION, '<=' ) ) {
			wp_enqueue_script( 'wc-cart-fragments' );
		}
	}

	/**
	 * Cart display via shortcode
	 * [fk_cart_menu]
	 *
	 * @return false|string
	 */
	public function mini_cart_shortcode_cb() {
		if ( is_admin() && ! wp_doing_ajax() ) {
			return '';
		}
		if ( false === Data::is_cart_enabled( 'shortcode' ) ) {
			return '';
		}

		add_action( 'wp_footer', [ $this, 'cart_content' ], 99 );

		return $this->get_mini_cart_toggler();
	}

	/**
	 * Get mini cart HTML
	 *
	 * @return false|string
	 */
	public function get_mini_cart_toggler() {
		ob_start();
		$style = Data::get_active_mini_cart_skin();
		fkcart_get_template_part( 'site/mini-' . $style );

		return ob_get_clean();
	}

	/**
	 * Attach fragment
	 *
	 * @param $fragments
	 *
	 * @return mixed
	 */
	public function button_icon_fragments( $fragments ) {
		ob_start();
		$this->cart_icon();
		$fragments['#fkcart-floating-toggler'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Floating cart icon view
	 *
	 * @return void
	 */
	public function cart_icon() {
		if ( false === Data::is_cart_enabled() ) {
			return;
		}
		$style = Data::get_active_icon_style();

		fkcart_get_template_part( 'site/button-' . $style );
	}

	/**
	 * Floating cart contact view
	 *
	 * @return string|void
	 */
	public function cart_content() {
		if ( false === Data::is_cart_enabled( 'all' ) ) {
			return '';
		}
		if ( true === $this->drawer_displayed ) {
			return;
		}
		$upsell_style  = Data::get_value( 'upsell_style' );
		$upsell_style  = empty( $upsell_style ) ? 'style1' : $upsell_style;
		$icon_position = Data::get_value( 'cart_icon_position' );
		?>
        <div id="fkcart-modal" class="fkcart-modal" data-upsell-style="<?php esc_attr_e( $upsell_style ); ?>">
            <div class="fkcart-modal-container" data-direction="<?php esc_attr_e( is_rtl() ? 'rtl' : 'ltr' ); ?>" data-slider-pos="<?php esc_attr_e( $icon_position ); ?>">
				<?php fkcart_get_template_part( 'cart/placeholder' ); ?>
            </div>
        </div>
		<?php
		$this->drawer_displayed = true;
	}

	/**
	 * Public localize data
	 *
	 * @return array
	 */
	public function localize_data() {
		$ajax_url                    = admin_url( 'admin-ajax.php' );
		$query                       = apply_filters( 'fkcart_admin_ajax_args', [] );
		$is_ajax_add_to_cart_enabled = wc_string_to_bool( Data::get_value( 'ajax_add_to_cart' ) ) && is_product() && ! self::is_excluded_product_types() ? 'yes' : 'no';
		$arr                         = [
			'ajax_nonce'        => wp_create_nonce( 'fkcart' ),
			'is_preview'        => fkcart_is_preview(),
			'ajax_url'          => ! empty( $query ) ? add_query_arg( $query, $ajax_url ) : $ajax_url,
			'force_open_cart'   => 'no',
			'open_side_cart'    => $this->add_to_cart_trigger ? 'yes' : 'no',
			'should_open_cart'  => 'yes',
			'is_cart'           => is_cart(),
			'is_shop'           => is_shop(),
			'is_single_product' => is_product(),
			'ajax_add_to_cart'  => apply_filters( 'fkcart_is_ajax_add_to_cart_enabled', $is_ajax_add_to_cart_enabled, $this ),
			'wc_endpoints'      => AJAX::get_public_endpoints( $query ),
		];
		$auto_open_cart              = Data::get_value( 'enable_auto_open_cart' );
		if ( 0 === intval( $auto_open_cart ) || false === $auto_open_cart || 'false' === strval( $auto_open_cart ) ) {
			$arr['should_open_cart'] = 'no';
		}

		if ( true === $this->add_to_cart_trigger ) {
			$arr['force_open_cart'] = 'yes';
		}

		return $arr;
	}

	/**
	 * Get current cart count
	 *
	 * @return int
	 */
	public function get_cart_content_count() {
		return fkcart_is_preview() ? 2 : ( ! is_null( WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0 );
	}

	/**
	 * Get cart items
	 *
	 * @return array
	 */
	public function get_items() {
		$items = [];
		add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false' ); //Do not append attributes with title

		/** When preview */
		if ( fkcart_is_preview() ) {
			$products = fkcart_get_dummy_products();
			$items[]  = $this->get_dummy_preview_item( $products[1] );
			$items[]  = $this->get_dummy_preview_item( $products[2] );

			return $items;
		}

		WC()->cart->calculate_totals();
		$cart_contents = WC()->cart->get_cart_contents();
		foreach ( $cart_contents as $cart_item_key => $cart_item ) {
			$items[ $cart_item_key ] = $this->get_cart_items( $cart_item_key, $cart_item );
		}

		return $items;
	}

	/**
	 * Prepare product data from product object
	 *
	 * @param $_product \WC_Product
	 *
	 * @return array
	 */
	public function get_preview_item( $_product ) {
		$show_link = apply_filters( 'fkcart_enable_item_link', true );

		$product_id        = $_product->get_id();
		$product_permalink = $_product->is_visible() ? $_product->get_permalink() : '';
		$product_name      = $_product->get_name();
		$product_name      = $product_permalink && $show_link ? sprintf( '<a href="%s" class="fkcart-item-title">%s</a>', $product_permalink, $product_name ) : $product_name;
		$product_price     = $_product->get_price();
		$product_subtotal  = $_product->get_price();

		$size      = apply_filters( 'fkcart_item_image_size', 'thumbnail' );
		$thumbnail = $_product->get_image( $size, [
			'class'   => 'fkcart-image',
			'loading' => 'lazy'
		] );
		$thumbnail = $product_permalink && $show_link ? sprintf( '<a href="%s" class="fkcart-image-wrapper" tabindex="-1" aria-hidden="true"><span>%s</span></a>', esc_url( $product_permalink ), $thumbnail ) : sprintf( '<div class="fkcart-image-wrapper"><span>%s</span></div>', $thumbnail );

		return [
			'is_cart_item'      => 0,
			'product'           => $_product,
			'product_id'        => $product_id,
			'product_permalink' => $product_permalink,
			'product_name'      => $product_name,
			'product_price'     => $_product->get_type() == 'variable' ? $_product->get_price_html() : $product_price,
			'product_subtotal'  => $product_subtotal,
			'thumbnail'         => $thumbnail,
			'quantity'          => 1,
			'price'             => wc_price( 50 ),
			'_fkcart_free_gift' => false,
			'sold_individually' => $_product->is_sold_individually(),
			'product_meta'      => ''
		];
	}

	/**
	 * Get dummy product HTML
	 *
	 * @param $product
	 *
	 * @return array
	 */
	public function get_dummy_preview_item( $product ) {
		$saving = '';
		if ( isset( $product['sale_price'] ) && ( $product['price'] - $product['sale_price'] ) > 0 ) {
			$saving = ( ( $product['price'] - $product['sale_price'] ) * 100 ) / $product['price'];
			$saving = number_format( $saving, 2 );
		}

		return [
			'product_id'     => rand( 1, 10 ),
			'thumbnail'      => '<a href="#" class="fkcart-image-wrapper"><img width="150" height="150" src="' . esc_url( plugin_dir_url( FKCART_PLUGIN_FILE ) . 'admin/assets/img/dummy/' . $product['image'] ) . '" class="fkcart-image"/></a>',
			'product_name'   => '<a href="#" class="fkcart-item-title">' . $product['name'] . '</a>',
			'product_meta'   => isset( $product['meta'] ) ? $product['meta'] : '',
			'price'          => ( isset( $product['sale_price'] ) ) ? wc_price( $product['sale_price'] ) : wc_price( $product['price'] ),
			'saving_percent' => $saving,
			'saving_amount'  => number_format( $product['price'] - $product['sale_price'], 2 ),
		];
	}

	/**
	 * Prepare product data from cart item
	 *
	 * @param $cart_item_key
	 * @param $cart_item
	 *
	 * @return array|null
	 */
	public function get_cart_items( $cart_item_key, $cart_item ) {
		$show_link = apply_filters( 'fkcart_enable_item_link', true );

		/** @var \WC_Product $_product */
		$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] < 0 || ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			return [ 'visibility_hidden' => 'yes' ];
		}

		$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
		$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
		$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
		$product_subtotal  = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );

		/** Some hooks modify price on get_product_subtotal */
		$raw_subtotal = preg_replace( "/[^0-9]/", '', strip_tags( ! is_null( $product_subtotal ) ? $product_subtotal : '' ) );

		$size      = apply_filters( 'fkcart_item_image_size', 'thumbnail' );
		$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( $size, [
			'class'   => 'fkcart-image',
			'loading' => 'lazy'
		] ), $cart_item, $cart_item_key );
		$thumbnail = $product_permalink && $show_link ? sprintf( '<a href="%s" class="fkcart-image-wrapper" tabindex="-1" aria-hidden="true">%s</a>', esc_url( $product_permalink ), $thumbnail ) : sprintf( '<div class="fkcart-image-wrapper">%s</div>', $thumbnail );

		$product_name           = $product_permalink && $show_link ? sprintf( '<a href="%s" class="fkcart-item-title">%s</a>', $product_permalink, $product_name ) : sprintf( '<div class="fkcart-item-title">%s</div>', $product_name );
		$product_meta           = fkcart_get_formatted_cart_item_data( $cart_item );
		$product_delete_icon    = apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'woocommerce' ), esc_attr( $product_id ), esc_attr( $_product->get_sku() ) ), $cart_item_key );
		$product_quantity_input = woocommerce_quantity_input( array(
			'input_name'   => "cart[{$cart_item_key}][qty]",
			'input_value'  => $cart_item['quantity'],
			'max_value'    => 1,
			'min_value'    => 1,
			'product_name' => $_product->get_name(),
		), $_product, false );
		$product_quantity_input = apply_filters( 'woocommerce_cart_item_quantity', $product_quantity_input, $cart_item_key, $cart_item );
		$product_quantity_input = is_numeric( $product_quantity_input ) && $product_quantity_input;

		return [
			'_fkcart_variation_gift' => isset( $cart_item['_fkcart_variation_gift'] ),
			'is_cart_item'           => $cart_item_key,
			'product'                => $cart_item['data'],
			'product_id'             => $product_id,
			'product_permalink'      => $product_permalink,
			'product_name'           => $product_name,
			'product_price'          => $product_price,
			'product_subtotal'       => $product_subtotal,
			'thumbnail'              => $thumbnail,
			'price'                  => $product_subtotal,
			'quantity'               => $cart_item['quantity'],
			'_fkcart_free_gift'      => apply_filters( 'fkcart_item_hide_delete_icon', isset( $cart_item['_fkcart_free_gift'] ) || empty( $product_delete_icon ), $cart_item ),
			'sold_individually'      => apply_filters( 'fkcart_cart_item_is_sold_individually', $_product->is_sold_individually() || $product_quantity_input || ! ( $raw_subtotal > 0 ), $cart_item ),
			'product_meta'           => $product_meta
		];
	}

	/**
	 * Get cart applied coupons
	 *
	 * @return array
	 */
	public function get_coupons() {
		if ( fkcart_is_preview() ) {
			$output['free20'] = [ 'code' => 'free20', 'value' => wc_price( $this->preview_discount ) ];

			return $output;
		}

		$output = [];
		foreach ( WC()->cart->get_coupons() as $code => $coupon ) {
			if ( is_string( $coupon ) ) {
				$coupon = new \WC_Coupon( $coupon );
			}
			$output[ $code ] = [ 'code' => $coupon->get_code(), 'value' => $this->wc_cart_totals_coupon_html( $coupon, false ) ];
		}

		return $output;
	}

	/**
	 * Get cart subtotal
	 *
	 * @param $raw
	 *
	 * @return float|int|string
	 */
	public function get_subtotal( $raw = false ) {
		if ( fkcart_is_preview() ) {
			$products = fkcart_get_dummy_products();
			$price    = $products[1]['sale_price'] + $products[2]['sale_price'];

			return false === $raw ? wc_price( $price ) : $price;
		}

		$price = $this->get_subtotal_row( true ) - WC()->cart->get_discount_total();
		if ( WC()->cart->display_prices_including_tax() ) {
			$price = $price - WC()->cart->get_discount_tax();
		}

		return false === $raw ? wc_price( $price ) : $price;
	}

	/**
	 * Get subtotal value to display in a row
	 *
	 * @return string
	 */
	public function get_subtotal_row( $raw = false ) {
		if ( fkcart_is_preview() ) {
			$products = fkcart_get_dummy_products();
			$price    = $products[1]['sale_price'] + $products[2]['sale_price'];

			return ( false === $raw ) ? wc_price( $price ) : $price;
		}

		$price = ( WC()->cart->display_prices_including_tax() ) ? WC()->cart->get_subtotal() + WC()->cart->get_subtotal_tax() : WC()->cart->get_subtotal();

		return ( false === $raw ) ? wc_price( $price ) : $price;
	}

	/**
	 * Get total value of cart after discount
	 *
	 * @return string
	 */
	public function get_total_row( $raw = false ) {
		if ( fkcart_is_preview() ) {
			$products = fkcart_get_dummy_products();
			$price    = $products[1]['sale_price'] + $products[2]['sale_price'];

			return ( false === $raw ) ? wc_price( $price ) : $price;
		}

		$price = ( WC()->cart->display_prices_including_tax() ) ? WC()->cart->get_cart_contents_total() + WC()->cart->get_cart_contents_tax() : WC()->cart->get_cart_contents_total();

		return ( false === $raw ) ? wc_price( $price ) : $price;
	}

	/**
	 * Get discounted sub total
	 * Used in admin preview only
	 *
	 * @return float|mixed|string
	 */
	public function get_discounted_subtotal() {
		if ( ! fkcart_is_preview() ) {
			return '';
		}
		$products = fkcart_get_dummy_products();
		$price    = $products[1]['sale_price'] + $products[2]['sale_price'] - $this->preview_discount;

		return wc_price( $price );
	}

	/**
	 * Get min max step for product input
	 *
	 * @param $_product \WC_Product
	 *
	 * @return array
	 */
	public function get_min_max_step( $_product ) {
		$defaults = array(
			'max_value' => apply_filters( 'woocommerce_quantity_input_max', - 1, $_product ),
			'min_value' => apply_filters( 'woocommerce_quantity_input_min', 0, $_product ),
			'step'      => apply_filters( 'woocommerce_quantity_input_step', 1, $_product )
		);

		$args = apply_filters( 'woocommerce_quantity_input_args', $defaults, $_product );

		/** Apply sanity to min/max args - min cannot be lower than 0 */
		$args['min_value'] = max( $args['min_value'], 0 );
		$args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : '';

		/** Max cannot be lower than min if defined */
		if ( '' !== $args['max_value'] && $args['max_value'] < $args['min_value'] ) {
			$args['max_value'] = $args['min_value'];
		}

		return [ $args['min_value'], $args['max_value'], $args['step'] ];
	}

	/**
	 * Return or echo cart total
	 *
	 * @param $coupon
	 * @param $echo
	 *
	 * @return string|void
	 */
	function wc_cart_totals_coupon_html( $coupon, $echo = true ) {
		if ( is_string( $coupon ) ) {
			$coupon = new \WC_Coupon( $coupon );
		}

		$amount = WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax );

		$discount_amount_html = wc_price( $amount );

		if ( $coupon->get_free_shipping() && empty( $amount ) ) {
			$discount_amount_html = __( 'Free shipping coupon', 'woocommerce' );
		}

		$discount_amount_html = apply_filters( 'woocommerce_coupon_discount_amount_html', $discount_amount_html, $coupon );
		$value                = apply_filters( 'woocommerce_cart_totals_coupon_html', $discount_amount_html, $coupon, $discount_amount_html );

		if ( $echo ) {
			echo wp_kses( $value, array_replace_recursive( wp_kses_allowed_html( 'post' ), array( 'a' => array( 'data-coupon' => true ) ) ) ); // phpcs:ignore PHPCompatibility.PHP.NewFunctions.array_replace_recursiveFound

			return;
		}

		return wp_kses( $value, array_replace_recursive( wp_kses_allowed_html( 'post' ), array( 'a' => array( 'data-coupon' => true ) ) ) ); // phpcs:ignore PHPCompatibility.PHP.NewFunctions.array_replace_recursiveFound
	}

	/**
	 * @param $product \WC_Product
	 *
	 * @return float|int|string
	 */
	function you_saved_price( $product, $qty = 1 ) {
		if ( ! $product instanceof \WC_Product ) {
			return '';
		}
		$percentage            = '';
		$amount                = 0;
		$tax_display_mode      = get_option( 'woocommerce_tax_display_shop' );
		$product_regular_price = 'incl' === $tax_display_mode ? wc_get_price_including_tax( $product, [ 'price' => $product->get_regular_price( 'edit' ) ] ) : wc_get_price_excluding_tax( $product, [ 'price' => $product->get_regular_price( 'edit' ) ] );
		$product_price         = 'incl' === $tax_display_mode ? wc_get_price_including_tax( $product, [ 'price' => $product->get_price( 'edit' ) ] ) : wc_get_price_excluding_tax( $product, [ 'price' => $product->get_price( 'edit' ) ] );

		if ( $product_regular_price > 0 && ! empty( $product_price ) && $product_price != $product_regular_price ) {
			$amount     = ( $product_regular_price - $product_price );
			$percentage = ( $amount * 100 ) / $product_regular_price;
		}

		if ( empty( $percentage ) ) {
			return '';
		}

		$round_value = apply_filters( 'fkcart_cart_item_saving_value_round', false, $percentage );


		if ( true === $round_value ) {
			$percentage = round( $percentage );
			$amount     = round( $amount * $qty );
		} else {
			$percentage = number_format( $percentage );
			$amount     = number_format( $amount * $qty, 2 );
		}

		return [ 'percentage' => $percentage, 'amount' => $amount ];
	}


	/**
	 * Set object when item is added to cart
	 *
	 * @return void
	 */
	public function add_to_cart_trigger() {
		$this->add_to_cart_trigger = true;

		$is_ajax_add_to_cart_enabled = wc_string_to_bool( Data::get_value( 'ajax_add_to_cart' ) );
		if ( false === $is_ajax_add_to_cart_enabled ) {
			Ajax::get_instance()->set_fkcart_cookies();
		}
	}

	/**
	 * Get add to cart prop value
	 *
	 * @return bool
	 */
	public function is_add_to_cart_trigger() {
		return $this->add_to_cart_trigger;
	}

	/**
	 * Get upsell products
	 *
	 * @return array
	 */
	public function get_upsell_products() {
		if ( class_exists( '\FKCart\Pro\Plugin' ) ) {
			if ( fkcart_is_preview() ) {
				return $this->get_dummy_upsell_products();
			}

			return \FKCart\Pro\Upsells::getInstance()->get_upsell_products();
		}

		return [];
	}

	/**
	 * Get dummy products
	 *
	 * @return array
	 */
	public function get_dummy_upsell_products() {
		$products = fkcart_get_dummy_products();
		$items[]  = $this->get_dummy_preview_item( $products[0] );
		$items[]  = $this->get_dummy_preview_item( $products[3] );
		$items[]  = $this->get_dummy_preview_item( $products[4] );

		return $items;
	}

	/**
	 * Get dummy product sale price
	 *
	 * @param $product
	 *
	 * @return mixed
	 */
	public function get_dummy_product_price( $product ) {
		return ( isset( $product['sale_price'] ) && ( $product['price'] - $product['sale_price'] ) > 0 ) ? $product['sale_price'] : $product['price'];
	}

	/**
	 * Append in menu
	 *
	 * @param $menu_items
	 * @param $args
	 *
	 * @return mixed|string
	 */
	public function append_cart_link( $menu_items, $args ) {
		if ( false === Data::is_cart_enabled( 'shortcode' ) || empty( $args->menu ) ) {
			return $menu_items;
		}

		$saved_menu = Data::get_value( 'cart_append_menu' );
		if ( empty( $saved_menu ) ) {
			return $menu_items;
		}
		$current_menu_id = ( $args->menu instanceof \WP_Term ) ? $args->menu->term_id : ( is_numeric( $args->menu ) ? $args->menu : false );
		if ( false === $current_menu_id || intval( $current_menu_id ) !== intval( $saved_menu ) ) {
			return $menu_items;
		}

		$menu_items .= "<li class='menu-item fkcart-custom-menu-link'>" . $this->get_mini_cart_toggler() . "</li>";

		return $menu_items;
	}

	/**
	 * Get HTML of Funnelkit Apple Pay & Google Pay Smart buttons
	 *
	 * @return false|string|void
	 */
	public function get_smart_buttons() {
		if ( fkcart_is_preview() ) {
			return;
		}

		if ( ! Data::is_smart_button_enabled() ) {
			return;
		}
		if ( ! class_exists( '\FKWCS\Gateway\Stripe\SmartButtons' ) ) {
			return;
		}
		add_filter( 'fkwcs_express_buttons_is_only_buttons', '__return_true', 20 );
		$instance = \FKWCS\Gateway\Stripe\SmartButtons::get_instance();
		// Credit card enabled checking already Handled in Payment_request_button settings below

		echo '<div class="fkcart-checkout-wrap fkcart-panel">';
		$instance->payment_request_button( true );
		echo '</div>';
	}

	/**
	 * Enqueue Smart button javascript button if smart button enabled inside the cart
	 * @return bool
	 */
	public function enqueue_smart_button_javascript() {
		return Data::is_smart_button_enabled();
	}

	public function handleCartFlickering() {
		if ( ! isset( $_REQUEST['fkcart-preview'] ) ) {
			return;
		}
		?>
        <script>
            window.addEventListener('DOMContentLoaded', function () {
                if (typeof wc_cart_fragments_params === 'undefined') {
                    return false;
                }
                var items = document.getElementsByClassName('fkcart-mini-open');
                if (items.length > 0 && 'sessionStorage' in window && window.sessionStorage !== null) {
                    sessionStorage.removeItem(wc_cart_fragments_params.fragment_name);
                }
            });

        </script>
		<?php
	}

	/**
	 * Append query currency & language parameter
	 *
	 * @return array
	 */
	public function append_ajax_parameter( $query ) {
		if ( isset( $_GET['currency'] ) ) {
			$query['currency'] = $_GET['currency'];
		}

		/** WPML Query parameter setting enabled */
		if ( isset( $_GET['lang'] ) ) {
			$query['lang'] = $_GET['lang'];
		}

		/** Polylang */
		if ( function_exists( 'pll_current_language' ) ) {
			$query['lang'] = pll_current_language();
		}

		/** Weglot */
		if ( function_exists( 'weglot_get_current_language' ) ) {
			$query['lang'] = weglot_get_current_language();
		}

		return $query;
	}

	/**
	 * Disable redirect to cart after adding product
	 *
	 * @param $status
	 *
	 * @return string
	 */
	public function disable_woocommerce_cart_redirect_after_add( $status ) {
		if ( 'no' === $status ) {
			return $status;
		}

		return ( false === Data::is_cart_enabled( 'all' ) ) ? $status : 'no';
	}

	/**
	 * Enable ajax on add product to cart
	 *
	 * @param $status
	 *
	 * @return mixed|string
	 */
	public function enable_woocommerce_enable_ajax_add_to_cart( $status ) {
		if ( 'yes' === $status || false === Data::is_cart_enabled( 'all' ) ) {
			return $status;
		}
		$force_ajax = Data::get_value( 'ajax_add_to_cart' );
		if ( ( 1 === intval( $force_ajax ) || true === $force_ajax || 'true' === strval( $force_ajax ) ) ) {
			return 'yes';
		}

		return $status;
	}

	/**
	 * Do not run ajax on add to cart for Excluded product types
	 *
	 * @return bool
	 */
	public function is_excluded_product_types() {
		$product_id = get_the_ID();
		if ( empty( $product_id ) ) {
			return false;
		}
		$product = wc_get_product( $product_id );
		if ( ! $product instanceof \WC_Product ) {
			return false;
		}
		$excluded_product_type = apply_filters( 'fkcart_ajax_add_to_cart_excluded_product_types', [ 'grouped', 'external' ] );
		if ( empty( $excluded_product_type ) ) {
			return false;
		}

		return in_array( $product->get_type(), $excluded_product_type, true );
	}

	/**
	 * Register Shortcode
	 *
	 * @return void
	 */
	public function register_shortcode() {
		add_shortcode( 'fk_cart_menu', [ $this, 'mini_cart_shortcode_cb' ] );
	}
}
