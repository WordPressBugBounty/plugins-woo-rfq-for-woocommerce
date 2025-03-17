<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$view_your_cart_text = get_option('rfq_cart_wordings_view_rfq_cart', __('View List', 'woo-rfq-for-woocommerce'));


echo "<div style='display: block'><a  class='link_to_rfq_page_link' href='".wp_kses_post($link_to_rfq_page)."' >".wp_kses_post($view_your_cart_text)."</a></div>";

?>