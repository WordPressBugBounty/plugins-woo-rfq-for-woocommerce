<?php
/**
 * Email Order Items (plain)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails/Plain
 * @version     3.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $show_prices;

$show_prices = apply_filters( 'gpls_woo_rfq_order_item_product_show_price', $show_prices, $order );


if ($show_prices  == true) {
    gpls_woo_rfq_remove_filters();
}



foreach ( $items as $item_id => $item ) :
	$_product     = apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
	$item_meta    = new WC_Order_Item_Meta( $item, $_product );

	if ( apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {

		// Title
		echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item, false );

		// SKU
		if ( $show_sku && $_product->get_sku() ) {
			echo ' (#' . $_product->get_sku() . ')';
		}

		// allow other plugins to add additional product information here
		do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order );

		// Variation
		echo ( $item_meta_content = $item_meta->display( true, true ) ) ? "\n" . $item_meta_content : '';

		// Quantity
		echo "\n" . sprintf( __( 'Quantity: %s', 'woo-rfq-for-woocommerce' ), apply_filters( 'woocommerce_email_order_item_quantity', $item['qty'], $item ) );



		// Download URLs
		if ( $show_download_links && $_product->exists() && $_product->is_downloadable() ) {
			$download_files = $order->get_item_downloads( $item );
			$i              = 0;

			foreach ( $download_files as $download_id => $file ) {
				$i++;

				if ( count( $download_files ) > 1 ) {
					$prefix = sprintf( __( 'Download %d', 'woo-rfq-for-woocommerce' ), $i );
				} elseif ( $i == 1 ) {
					$prefix = __( 'Download', 'woo-rfq-for-woocommerce' );
				}

				echo "\n" . $prefix . '(' . esc_html( $file['name'] ) . '): ' . esc_url( $file['download_url'] );
			}
		}

		// allow other plugins to add additional product information here
		do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order );

	}

	// Note
	if ( $show_purchase_note && ( $purchase_note = get_post_meta( $_product->get_id(), '_purchase_note', true ) ) ) {
		echo "\n" . do_shortcode( wp_kses_post( $purchase_note ) );
	}

	echo "\n\n";

endforeach;
