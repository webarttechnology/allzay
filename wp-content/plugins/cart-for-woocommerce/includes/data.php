<?php

namespace FKCart\Includes;


class Data {
	private static $db_data = null;

	/**
	 * Get plugin all settings
	 *
	 * @return array
	 */
	public static function get_settings() {
		$db_values = self::get_db_settings();
		$db_values = self::get_translated_values( $db_values );

		return wp_parse_args( $db_values, self::get_default_settings() );
	}

	/**
	 * Get database saved settings
	 *
	 * @return false|mixed|null
	 */
	public static function get_db_settings() {
		if ( is_null( self::$db_data ) ) {
			self::$db_data = \get_option( 'fkcart_settings', [] );
		}

		return self::$db_data;
	}

	/**
	 * Get default settings
	 *
	 * @return array
	 */
	private static function get_default_settings() {
		return [
			'enable_cart'           => 0,
			'cart_display'          => 'entire',
			'cart_icon_position'    => 'bottom-right',
			'cart_style'            => 'side-cart',
			'cart_icon_style'       => 'style1',
			'hide_empty_cart'       => false,
			'ajax_add_to_cart'      => false,
			'enable_auto_open_cart' => true,
			'cart_heading'          => __( 'Review Your Cart', 'cart-for-woocommerce' ),
			'default_font'          => '',

			'enable_coupon_box'       => true,
			'coupon_display'          => 'minimized',
			'coupon_placeholder_text' => __( 'Coupon Code', 'cart-for-woocommerce' ),
			'coupon_heading'          => __( 'Got a discount code?', 'cart-for-woocommerce' ),
			'coupon_button_text'      => __( 'Apply', 'cart-for-woocommerce' ),

			'show_sub_total'                => true,
			'you_save'                      => true,
			'saving_text'                   => __( 'Save {{saving_percentage}}', 'cart-for-woocommerce' ),
			'shipping_tax_calculation_text' => __( 'Shipping & taxes may be re-calculated at checkout', 'cart-for-woocommerce' ),

			'show_button_lock_icon'     => false,
			'show_button_price'         => false,
			'show_shop_continue_link'   => true,
			'continue_shopping_text'    => __( 'Continue Shopping', 'cart-for-woocommerce' ),
			'checkout_button_text'      => __( 'Checkout', 'woocommerce' ),
			'zero_state_title'          => __( 'Your Cart is Empty', 'cart-for-woocommerce' ),
			'zero_state_description'    => __( 'Fill your cart with amazing items', 'cart-for-woocommerce' ),
			'zero_state_btn_text'       => __( 'Shop Now', 'cart-for-woocommerce' ),
			'zero_state_link_behaviour' => 'close_cart',

			'enable_upsells'      => true,
			'upsell_style'        => 'style1',
			'upsell_type'         => 'both',
			'upsell_heading'      => __( 'Frequently Bought Together', 'cart-for-woocommerce' ),
			'upsell_max_count'    => 5,
			'show_default_upsell' => false,

			'reward_title'             => __( 'Congrats! You have unlocked all the rewards.', 'cart-for-woocommerce' ),
			'reward_calculation_based' => 'subtotal',

			'css_desktop_width'            => 420,
			'css_mobile_width'             => 100,
			'css_bg_color'                 => '#ffffff',
			'css_border_color'             => '#eaeaec',
			'css_accent_color'             => '#0170b9',
			'css_button_bg_color'          => '#0170b9', // primary
			'css_button_text_color'        => '#ffffff', // primary font color
			'css_primary_text_color'       => '#24272d', // primary text color
			'css_secondary_text_color'     => '#24272dbe', // secondary text color
			'css_upsell_bg_color'          => '#E6F1F7',
			'css_animation_speed'          => 400,
			'css_border_radius'            => 3,
			'css_progressbar_active_color' => '#0170b9',

			'css_icon_color'                  => '#353030',
			'css_icon_bg_color'               => '#ffffff',
			'css_icon_count_bg_color'         => '#cf2e2e',
			'css_icon_count_color'            => '#ffffff',
			'icon_type'                       => 'style1',
			'floating_icon'                   => 'cart_1',
			'checkout_button_icon'            => 'cart_1',
			'floating_icon_size'              => '36',
			'css_floating_icon_border_radius' => '50',

			'enable_menu'                 => false,
			'cart_icon'                   => 'cart_1',
			'display_menu_product_count'  => true,
			'display_menu_total'          => true,
			'cart_append_menu'            => '',
			'continue_shopping_behaviour' => 'close_cart',
			'cart_menu_icon_size'         => '35',
			'cart_menu_text_size'         => '16',

			'smart_buttons' => false
		];
	}

	/**
	 * Check if side cart is enabled
	 *
	 * @param $type
	 *
	 * @return bool
	 */
	public static function is_cart_enabled( $type = 'front' ) {
		/** Return if display disabled */
		if ( self::is_display_disabled() ) {
			return false;
		}

		/** Return true if preview */
		$is_preview = filter_input( INPUT_GET, 'fkcart-preview' );
		if ( ! is_null( $is_preview ) && 1 === intval( $is_preview ) ) {
			return true;
		}

		/** Builder editor mode */
		if ( self::is_page_builder() ) {
			return false;
		}

		/** Return false if disabled */
		$val = self::get_value( 'enable_cart' );
		if ( 0 === intval( $val ) ) {
			return false;
		}

		if ( 'shortcode' === $type || 'all' === $type ) {
			/** If shortcode enabled */
			$val = self::get_value( 'enable_menu' );
			if ( 1 === intval( $val ) || true === $val || 'true' === strval( $val ) ) {
				return true;
			}

			if ( 'shortcode' === $type ) {
				return false;
			}
		}

		$display = self::get_value( 'cart_display' );

		/** If display entire website */
		if ( 'entire' === $display ) {
			return true;
		}

		/** If display none */
		if ( 'none' === $display ) {
			return false;
		}

		/** If display on WC pages only */
		if ( is_woocommerce() || is_shop() || is_product() || is_cart() ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if checkout page or a single page of disabled product types.
	 *
	 * @return bool
	 */
	public static function is_display_disabled() {
		return ( false === apply_filters( 'fkcart_is_cart_enabled', ! ( is_checkout() || self::is_disabled_post_types() ) ) );
	}

	/**
	 * Disabled Cart Functionality on Funnelkit Post types also leave filter hook.
	 *
	 * @return bool
	 */
	public static function is_disabled_post_types() {
		if ( true === apply_filters( 'fkcart_disabled_floating_cart_icon', false ) ) {
			return true;
		}

		global $post;

		if ( ! $post instanceof \WP_Post ) {
			return false;
		}

		return in_array( $post->post_type, apply_filters( 'fkcart_disabled_post_types', [ 'wfocu_offer', 'wfacp_checkout', 'wffn_landing', 'wffn_oty', 'wffn_optin', 'wffn_ty' ] ) );
	}

	/**
	 * Get active skin
	 *
	 * @return mixed|string
	 */
	public static function get_active_skin() {
		return self::get_value( 'cart_style' );
	}

	/**
	 * Get active icon style
	 *
	 * @return mixed|string
	 */
	public static function get_active_icon_style() {
		return self::get_value( 'icon_type' );
	}

	public static function get_active_mini_cart_skin() {
		return 'style1';
	}

	/**
	 * Check if hide empty cart enabled
	 *
	 * @return bool
	 */
	public static function hide_empty_cart() {
		$val = self::get_value( 'hide_empty_cart' );

		return ( 1 === intval( $val ) || true === $val || 'true' === strval( $val ) );
	}

	/**
	 * Check if coupons enabled
	 *
	 * @return bool
	 */
	public static function is_coupon_enabled() {
		$val = self::get_value( 'enable_coupon_box' );

		return ( 1 === intval( $val ) || true === $val || 'true' === strval( $val ) );
	}

	/**
	 * Check if upsells enabled
	 *
	 * @return bool
	 */
	public static function is_upsells_enabled() {
		if ( ! class_exists( '\FKCart\Pro\Upsells' ) ) {
			return false;
		}
		$val = self::get_value( 'enable_upsells' );

		return ( 1 === intval( $val ) || true === $val || 'true' === strval( $val ) );
	}

	/**
	 * Check if savings text enabled
	 *
	 * @return bool
	 */
	public static function is_you_saved_enabled() {
		$val = self::get_value( 'you_save' );

		return ( 1 === intval( $val ) || true === $val || 'true' === strval( $val ) );
	}

	/**
	 * Get product saving text
	 *
	 * @return mixed|string
	 */
	public static function you_save_text() {
		return self::get_value( 'saving_text' );
	}

	/**
	 * Check if rewards enabled
	 *
	 * @return bool
	 */
	public static function is_rewards_enabled() {
		if ( ! class_exists( '\FKCart\Pro\Rewards' ) ) {
			return false;
		}
		$val = self::get_value( 'reward' );

		return apply_filters( 'fkcart_reward_enabled', ( is_array( $val ) && count( $val ) > 0 ) );
	}


	/**
	 * Check if Smart Buttons enabled
	 *
	 * @return bool
	 */
	public static function is_smart_button_enabled() {
		if ( ! class_exists( 'FKWCS_Gateway_Stripe' ) ) {
			return false;
		}

		$val = self::get_value( 'smart_buttons' );
		if ( ! $val ) {
			return false;
		}

		$local_settings = \FKWCS\Gateway\Stripe\Helper::get_gateway_settings();
		if ( 'yes' !== $local_settings['express_checkout_enabled'] || 'yes' !== $local_settings['enabled'] ) {
			return false;
		}

		return true;
	}


	/**
	 * Get setting value
	 *
	 * @param $key
	 *
	 * @return mixed|string
	 */
	public static function get_value( $key ) {
		$settings = self::get_settings();
		if ( isset( $settings[ $key ] ) ) {
			return maybe_unserialize( $settings[ $key ] );
		}

		return '';
	}

	/**
	 * Get CSS vars
	 *
	 * @return string
	 */
	public static function get_css_var_style() {
		$var_style = "
		:root {
			--fkcart-primary-bg-color: " . self::get_value( 'css_button_bg_color' ) . ";
			--fkcart-primary-font-color: " . self::get_value( 'css_button_text_color' ) . ";
			--fkcart-primary-text-color: " . self::get_value( 'css_primary_text_color' ) . ";
			--fkcart-secondary-text-color: " . self::get_value( 'css_secondary_text_color' ) . ";
			--fkcart-accent-color: " . self::get_value( 'css_accent_color' ) . ";
			--fkcart-border-color: " . self::get_value( 'css_border_color' ) . ";
			--fkcart-error-color: #B00C0C;
			--fkcart-error-bg-color: #FFF0F0;
			--fkcart-reward-color: #f1b51e;
			--fkcart-bg-color: " . self::get_value( 'css_bg_color' ) . ";
			--fkcart-slider-desktop-width: " . self::get_value( 'css_desktop_width' ) . "px;
			--fkcart-slider-mobile-width: " . self::get_value( 'css_mobile_width' ) . "%;
			--fkcart-animation-duration: " . absint( self::get_value( 'css_animation_speed' ) ) / 1000 . "s;
			--fkcart-panel-color:" . self::get_value( 'css_upsell_bg_color' ) . ";
			--fkcart-color-black: #000000;
			--fkcart-success-color: #5BA238;
			--fkcart-success-bg-color: #EFF6EB;
			--fkcart-toggle-bg-color: " . self::get_value( 'css_icon_bg_color' ) . ";
			--fkcart-toggle-icon-color: " . self::get_value( 'css_icon_color' ) . ";
			--fkcart-toggle-count-bg-color: " . self::get_value( 'css_icon_count_bg_color' ) . ";
			--fkcart-toggle-count-font-color: " . self::get_value( 'css_icon_count_color' ) . ";
			--fkcart-progressbar-active-color: " . self::get_value( 'css_progressbar_active_color' ) . ";
			--fkcart-toggle-border-radius: " . self::get_value( 'css_floating_icon_border_radius' ) . "%;
			--fkcart-toggle-size: " . self::get_value( 'floating_icon_size' ) . ";
			--fkcart-border-radius: " . self::get_value( 'css_border_radius' ) . "px; 
			--fkcart-menu-icon-size: " . self::get_value( 'cart_menu_icon_size' ) . "px;
			--fkcart-menu-text-size: " . self::get_value( 'cart_menu_text_size' ) . "px;
		}";

		if ( ! empty( self::get_value( 'default_font' ) ) ) {
			$var_style .= "#fkcart-modal * {font-family: " . htmlspecialchars_decode( self::get_value( 'default_font' ) ) . "}";
		}

		return $var_style;
	}

	/**
	 * Save settings
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public static function save_settings( $data ) {
		$updated = update_option( 'fkcart_settings', $data, false );
		if ( $updated ) {
			do_action( 'fkcart_settings_saved', $data );

			return true;
		}

		return false;
	}

	/**
	 * Get language options if any language plugin is activated
	 *
	 * @return array
	 */
	public static function get_language_options() {
		$language_options = [];
		$default_language = get_locale();
		/** WPML */
		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			$languages = apply_filters( 'wpml_active_languages', null, null );
			if ( ! empty( $languages ) ) {
				foreach ( $languages as $language ) {
					$code = isset( $language['language_code'] ) ? $language['language_code'] : $language['code'];
					if ( $default_language !== $code ) {
						$language_options[ $code ] = ! empty( $language['translated_name'] ) ? $language['translated_name'] : $language['native_name'];
					}
				}
			}
		}

		/** Polylang */
		if ( function_exists( 'pll_the_languages' ) ) {
			$languages = pll_the_languages( array( 'raw' => 1, 'hide_if_empty' => 0 ) );
			if ( ! empty( $languages ) ) {
				foreach ( $languages as $language ) {
					if ( $default_language !== $language['slug'] ) {
						$language_options[ $language['slug'] ] = $language['name'];
					}
				}
			}
		}

		/** TranslatePress **/
		if ( fkcart_is_translatepress_active() ) {
			$trp                 = \TRP_Translate_Press::get_trp_instance();
			$trp_languages       = $trp->get_component( 'languages' );
			$trp_languages_array = $trp_languages->get_languages( 'english_name' );

			$languages = ! empty( get_option( 'trp_settings' ) ) ? get_option( 'trp_settings' ) : array();
			$languages = isset( $languages['translation-languages'] ) ? $languages['translation-languages'] : array();
			if ( ! empty( $languages ) ) {
				foreach ( $languages as $language ) {
					if ( $default_language !== $language ) {
						$language_options[ $language ] = $language;
					}
				}
			}

			$language_options = array_intersect_key( $trp_languages_array, $language_options );
		}

		/** Weglot */
		if ( fkcart_is_weglot_active() ) {
			$data = \Context_Weglot::weglot_get_context()->get_service( 'Language_Service_Weglot' )->get_original_and_destination_languages();
			foreach ( $data as $lang_key => $lang ) {
				if ( ! $lang instanceof \Weglot\Client\Api\LanguageEntry && $default_language === $lang->getInternalCode() ) {
					continue;
				}
				$language_options[ $lang->getInternalCode() ] = $lang->getLocalName();
			}
		}

		return $language_options;
	}

	public static function get_default_lanagage() {
		/** WPML */
		if ( function_exists( 'icl_get_languages' ) ) {
			return icl_get_default_language();
		}

		/** Polylang */
		if ( function_exists( 'pll_the_languages' ) ) {
			return pll_default_language();
		}

		/** TranslatePress **/
		if ( fkcart_is_translatepress_active() ) {
			$language_settings = ! empty( get_option( 'trp_settings' ) ) ? get_option( 'trp_settings' ) : array();
			if ( isset( $language_settings['default-language'] ) ) {
				return $language_settings['default-language'];
			}
		}

		/** Weglot */
		if ( fkcart_is_weglot_active() ) {
			return weglot_get_original_language();
		}

		return get_locale();
	}

	/**
	 * Get translated value for front-end
	 *
	 * @param $db_values
	 *
	 * @return mixed
	 */
	public static function get_translated_values( $db_values ) {
		if ( ( is_admin() && ! wp_doing_ajax() ) || ! isset( $db_values['language'] ) || empty( self::get_language_options() ) ) {
			return $db_values;
		}
		$languages     = self::get_language_code();
		$language_data = [];
		foreach ( $languages as $current_lang ) {
			if ( isset( $db_values['language'][ $current_lang ] ) ) {
				$language_data = $db_values['language'][ $current_lang ];
				break;
			}
		}
		/** If current language data is not in db */
		if ( empty( $language_data ) ) {
			return $db_values;
		}

		/** Replace db values with translated values */
		foreach ( $language_data as $key => $value ) {
			$pos = strpos( $key, 'reward_field_' );
			if ( $pos !== false ) {
				$pos = explode( '_', $key );
				$pos = end( $pos );
				if ( isset( $db_values['reward'][ $pos - 1 ] ) ) {
					$db_values['reward'][ $pos - 1 ]['title'] = $value;
				}
				continue;
			}

			if ( ! isset( $db_values[ $key ] ) ) {
				continue;
			}

			$db_values[ $key ] = $value;
		}

		return $db_values;
	}

	/**
	 * Get template API URL
	 *
	 * @return string
	 */
	public static function get_template_api_url() {
		return 'https://gettemplates.funnelkit.com/';
	}

	/**
	 * Returns checkout pages data
	 *
	 * @return array|mixed|null
	 */
	public static function get_checkout_data() {
		$transient_data = get_transient( 'fkcart_templates_v3' );
		if ( false !== $transient_data ) {
			return $transient_data;
		}

		/** If transient data is not set */
		$json_templates = [];
		$endpoint_url   = self::get_template_api_url();
		$request_args   = array(
			'timeout'   => 30, //phpcs:ignore WordPressVIPMinimum.Performance.RemoteRequestTimeout.timeout_timeout
			'sslverify' => false
		);
		$response       = wp_safe_remote_get( $endpoint_url . 'templatesv3.json', $request_args );
		if ( ! is_wp_error( $response ) ) {
			$body = wp_remote_retrieve_body( $response );
			if ( ! empty( $body ) ) {
				$json_templates = json_decode( $body, true );

				set_transient( 'fkcart_templates_v3', $json_templates, 3 * DAY_IN_SECONDS );
			}
		}

		return $json_templates;
	}

	/**
	 * return of language combination like en,en-us,en_US,en_us
	 * @return array
	 */
	public static function get_language_code() {
		/** We found weGlot automatically convert all pages automatically. but we need to return array with current language */
		if ( function_exists( 'weglot_get_current_language' ) ) {
			return [ weglot_get_current_language() ];
		}

		$local        = get_locale();
		$current_lang = strtolower( $local );
		$separator    = false !== strpos( $current_lang, '-' ) ? '-' : '_';
		$codes        = explode( $separator, $current_lang );
		$hyphen_lang  = str_replace( '_', '-', $current_lang );

		return [ $codes[0], $current_lang, $hyphen_lang, $local ];
	}

	/**
	 * Load cart assets
	 *
	 * @return void
	 */
	public static function load_cart_assets() {
		$min     = ( defined( 'FKCART_IS_DEV' ) && true === FKCART_IS_DEV ) ? '' : '.min';
		$version = ( defined( 'FKCART_IS_DEV' ) && true === FKCART_IS_DEV ) ? time() : FKCART_VERSION;

		wp_enqueue_script( 'fkcart-carousel', FKCART_PLUGIN_URL . '/assets/addon/embla-carousel.min.js', [], $version, true );
		wp_enqueue_script( 'fkcart-script', FKCART_PLUGIN_URL . '/assets/js/cart' . $min . '.js', [ 'jquery', 'fkcart-carousel' ], $version, true );
		wp_enqueue_style( 'fkcart-style', FKCART_PLUGIN_URL . '/assets/css/style' . $min . '.css', [], $version, 'all' );
		wp_add_inline_style( 'fkcart-style', self::get_css_var_style() );
	}

	/**
	 * Load cart assets in admin
	 *
	 * @return void
	 */
	public static function load_admin_assets() {
		$version = ( defined( 'FKCART_IS_DEV' ) && true === FKCART_IS_DEV ) ? time() : FKCART_VERSION;

		wp_enqueue_script( 'fkcart-admin-script', FKCART_PLUGIN_URL . '/admin/assets/js/cart.min.js', [], $version, true );
		wp_enqueue_style( 'fkcart-style', FKCART_PLUGIN_URL . '/assets/css/style.min.css', [], $version, 'all' );
		wp_add_inline_style( 'fkcart-style', self::get_css_var_style() );
	}

	/**
	 * Get all cart icons
	 *
	 * @return array
	 */
	public static function get_cart_icon_list() {
		$icons     = [];
		$icon_list = @scandir( FKCART_PLUGIN_DIR . '/templates/icon/cart' );
		if ( ! empty( $icon_list ) ) {
			foreach ( $icon_list as $value ) {
				if ( ! in_array( $value, array( '.', '..' ), true ) ) {
					$icon_name = str_replace( ".php", "", $value );
					if ( $icon_name !== 'index' ) {
						$icons[ $icon_name ] = fkcart_get_template_part( 'site/button-style1', '', [ 'floating_icon' => $icon_name ], false );
					}
				}
			}
		}

		return $icons;
	}

	/**
	 * Get rewards
	 *
	 * @return array|null
	 */
	public static function get_rewards() {
		if ( ! class_exists( '\FKCart\Pro\Rewards' ) ) {
			return [];
		}

		return \FKCart\Pro\Rewards::get_rewards();
	}

	/**
	 * Check if free shipping method available
	 *
	 * @return bool
	 */
	public static function check_free_shipping_method_available() {
		global $wpdb;

		$sql     = $wpdb->prepare( "SELECT * FROM `{$wpdb->prefix}woocommerce_shipping_zone_methods` WHERE `method_id` LIKE %s and `is_enabled`=%d", 'free_shipping', 1 );
		$results = $wpdb->get_results( $sql, ARRAY_A );

		return ! empty( $results );
	}

	public static function is_page_builder() {
		// oxygen builder
		$oxygen_builder = filter_input( INPUT_GET, 'ct_builder' );
		if ( ! is_null( $oxygen_builder ) ) {
			return true;
		}

		// elementor builder
		if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview instanceof \Elementor\Preview && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			return true;
		}

		// divi page builder
		if ( self::is_divi_page() ) {
			return true;
		}

		// customizer page
		if ( self::is_customizer() ) {
			return true;
		}

		return apply_filters( 'fkcart_is_page_builder', false );
	}

	/**
	 * Check for divi edit page
	 *
	 * @return bool
	 */
	public static function is_divi_page() {
		if ( filter_has_var( INPUT_GET, 'et_fb' ) ) {
			return true;

		}

		return false;
	}

	/**
	 * Check our customizer page is open or not
	 * @return bool
	 */
	public static function is_customizer() {
		if ( filter_has_var( INPUT_GET, 'customize_changeset_uuid' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * When Rewards sections are not run properly after some action like add,remove,update,delete items then run get slide cart ajax
	 * Issue with wpml-multicurrency or others plugins.
	 *
	 * @return bool
	 */
	public static function need_re_run_get_slide_cart_ajax() {
		return apply_filters( 'fkcart_re_run_get_slide_cart_ajax', false );
	}

	public static function fkcart_frontend_cookie_names() {
		$default_names = [ 'quantity' => 'fkcart_cart_qty', 'cart_total' => 'fkcart_cart_total' ];
		$cookie_names  = apply_filters( 'fkcart_frontend_cookie_names', $default_names );
		$quantity      = isset( $cookie_names['quantity'] ) && ! empty( $cookie_names['quantity'] ) ? $cookie_names['quantity'] : $default_names['quantity'];
		$cart_total    = isset( $cookie_names['cart_total'] ) && ! empty( $cookie_names['cart_total'] ) ? $cookie_names['cart_total'] : $default_names['cart_total'];

		return [ 'quantity' => $quantity, 'cart_total' => $cart_total ];
	}
}
