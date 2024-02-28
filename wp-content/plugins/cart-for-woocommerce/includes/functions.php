<?php

use FKCart\Includes\Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'fkcart_is_wc_active' ) ) {
	/**
	 * WC active check
	 *
	 * @return bool
	 */
	function fkcart_is_wc_active() {
		if ( class_exists( '\WooCommerce' ) ) {
			return true;
		}

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'fkcart_get_template_part' ) ) {
	/**
	 * Get template path data
	 *
	 * @param $slug
	 * @param $name
	 * @param $args
	 * @param $echo
	 *
	 * @return false|string|void
	 */
	function fkcart_get_template_part( $slug, $name = '', $args = [], $echo = true ) {
		if ( $args && is_array( $args ) ) {
			extract( $args ); // phpcs:ignore
		}

		$template = '';

		/** Try to locate file in your theme. theme/cart-for-woocommerce/slug-name.php and theme/cart-for-woocommerce/slug.php */
		$template_path = ! empty( $name ) ? "{$slug}-{$name}.php" : "{$slug}.php";
		$template      = locate_template( [ 'cart-for-woocommerce/' . $template_path ] );

		/** Can alter template directory path */
		$template_path = apply_filters( 'fkcart_set_template_path', FKCART_PLUGIN_DIR . '/templates', $template, $args );

		/** Try to locate slug-name.php */
		if ( ! $template && $name && file_exists( $template_path . "/{$slug}-{$name}.php" ) ) {
			$template = $template_path . "/{$slug}-{$name}.php";
		}

		/** Try to locate slug.php */
		if ( ! $template && ! $name && file_exists( $template_path . "/{$slug}.php" ) ) {
			$template = $template_path . "/{$slug}.php";
		}

		/** Allow altering template file path */
		$template = apply_filters( 'fkcart_get_template_part', $template, $slug, $name );
		if ( ! $template ) {
			return;
		}

		/** Echo data */
		if ( true === $echo ) {
			require $template;

			return '';
		}

		/** Return data */
		ob_start();
		require $template;

		return ob_get_clean();
	}
}

if ( ! function_exists( 'fkcart_variable_product_type' ) ) {
	/**
	 * Check if product type is variable
	 *
	 * @param $type
	 *
	 * @return bool
	 */
	function fkcart_is_variable_product_type( $type ) {
		return in_array( $type, [ 'variable', 'variable-subscription' ] );
	}
}

if ( ! function_exists( 'fkcart_variation_product_type' ) ) {
	/**
	 * Check if product type is variation
	 *
	 * @param $type
	 *
	 * @return bool
	 */
	function fkcart_is_variation_product_type( $type ) {
		return in_array( $type, [ 'variation', 'subscription_variation' ] );
	}
}

if ( ! function_exists( 'fkcart_is_preview' ) ) {
	/**
	 * Check if Cart admin preview
	 *
	 * @return mixed|null
	 */
	function fkcart_is_preview() {
		return apply_filters( 'fkcart_is_preview', isset( $_REQUEST['page'] ) && 'fkcart' == $_REQUEST['page'] );
	}
}

if ( ! function_exists( 'fkcart_get_active_skin_html' ) ) {
	/**
	 * Get active skin HTML
	 *
	 * @return false|string|null
	 */
	function fkcart_get_active_skin_html() {
		$skin = Data::get_active_skin();

		return fkcart_get_template_part( 'skin/' . $skin, '', [], false );
	}
}

if ( ! function_exists( 'fkcart_mini_cart_html' ) ) {
	/**
	 * Get active skin HTML
	 *
	 * @return false|string|null
	 */
	function fkcart_mini_cart_html() {
		$front = \FKCart\Includes\Front::get_instance();

		return $front->get_mini_cart_toggler();
	}
}

if ( ! function_exists( 'fkcart_get_dummy_products' ) ) {
	/**
	 * Get dummy products list
	 *
	 * @return array[]
	 */
	function fkcart_get_dummy_products() {
		return [
			0 => [
				"name"       => "Wool Knife",
				"price"      => 50,
				"sale_price" => 47.5,
				"image"      => '4.png',
			],
			1 => [
				"name"       => "Rubber Shoes",
				"price"      => 40,
				"sale_price" => 36,
				"image"      => '2.png',
				"meta"       => '<span class="fkcart-attr-wrap"><span class="fkcart-attr-key">Color</span>:<span class="fkcart-attr-value">Green</span></span>',
			],
			2 => [
				"name"       => "Silk Hat",
				"price"      => 120,
				"sale_price" => 120,
				"image"      => '1.png',
			],
			3 => [
				"name"       => "Bronze Bottle",
				"price"      => 15,
				"sale_price" => 14,
				"image"      => '5.png',
			],
			4 => [
				"name"       => "Iron Pants",
				"price"      => 75,
				"sale_price" => 75,
				"image"      => '3.png',
			],
		];
	}
}

if ( ! function_exists( 'fkcart_is_weglot_active' ) ) {
	/**
	 * Weglot language plugin active check
	 *
	 * @return bool
	 */
	function fkcart_is_weglot_active() {
		if ( defined( 'WEGLOT_NAME' ) ) {
			return true;
		}

		return in_array( 'weglot/weglot.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
	}
}

if ( ! function_exists( 'fkcart_is_translatepress_active' ) ) {
	/**
	 * Translatepress language plugin active check
	 *
	 * @return bool
	 */
	function fkcart_is_translatepress_active() {
		return in_array( 'translatepress-multilingual/index.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
	}
}
if ( ! function_exists( 'fkcart_free_shipping_method' ) ) {
	/**
	 * Get WC free shipping methods
	 *
	 * @return string[]
	 */
	function fkcart_free_shipping_method() {
		return [ 'free_shipping', 'table_rate', 'flexible_shipping_single' ];
	}
}

if ( ! function_exists( 'fkcart_get_formatted_cart_item_data' ) ) {
	/**
	 * Get WC cart item formatted data
	 *
	 * @param $cart_item
	 *
	 * @return string
	 */
	function fkcart_get_formatted_cart_item_data( $cart_item ) {
		$item_data = array();

		/** Variation values are shown only if they are not found in the title as of 3.0. */
		/** This is because variation titles display the attributes */
		if ( $cart_item['data']->is_type( 'variation' ) && is_array( $cart_item['variation'] ) ) {
			foreach ( $cart_item['variation'] as $name => $value ) {
				$taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );
				if ( taxonomy_exists( $taxonomy ) ) {
					/** If this is a term slug, get the term's nice name */
					$term = get_term_by( 'slug', $value, $taxonomy );
					if ( ! is_wp_error( $term ) && $term && $term->name ) {
						$value = $term->name;
					}
					$label = wc_attribute_label( $taxonomy );
				} else {
					/** If this is a custom option slug, get the options name */
					$value = apply_filters( 'woocommerce_variation_option_name', $value, null, $taxonomy, $cart_item['data'] );
					$label = wc_attribute_label( str_replace( 'attribute_', '', $name ), $cart_item['data'] );
				}
				$item_data[] = array(
					'key'   => $label,
					'value' => $value,
				);
			}
		}

		/** Filter item data to allow 3rd parties to add more to the array */
		$item_data = apply_filters( 'woocommerce_get_item_data', $item_data, $cart_item );

		/** Format item data ready to display */
		foreach ( $item_data as $key => $data ) {
			/** Set hidden to true to not display meta on cart */
			if ( ! empty( $data['hidden'] ) ) {
				unset( $item_data[ $key ] );
				continue;
			}
			$item_data[ $key ]['key']     = ! empty( $data['key'] ) ? $data['key'] : $data['name'];
			$item_data[ $key ]['display'] = ! empty( $data['display'] ) ? $data['display'] : $data['value'];
		}
		$output = '';
		if ( count( $item_data ) > 0 ) {
			foreach ( $item_data as $data ) {
				$output .= sprintf( '<span class="fkcart-attr-wrap"><span class="fkcart-attr-key" data-attr-key="%1$s">%1$s:</span><span class="fkcart-attr-value">%2$s</span></span>', wp_kses_post( $data['key'] ), wp_kses_post( $data['display'] ) ) . "\n";
			}
		}

		return $output;
	}
}

if ( ! function_exists( 'fkcart_fb_pro_min_version_verified' ) ) {
	/**
	 * Check FB Pro min version
	 *
	 * @param $compare_version
	 *
	 * @return bool|int
	 */
	function fkcart_fb_pro_min_version_verified( $compare_version = '' ) {
		$pro_version = defined( 'WFFN_PRO_BUILD_VERSION' ) ? WFFN_PRO_BUILD_VERSION : 0;

		$v2 = empty( $compare_version ) ? FKCART_MIN_FB_PRO_VERSION : $compare_version;

		return version_compare( $pro_version, $v2, '>=' );
	}
}
