<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$view_your_cart_text = get_option('rfq_cart_wordings_view_rfq_cart', __('View List', 'woo-rfq-for-woocommerce'));
//$view_your_cart_text = __($view_your_cart_text, 'woo-rfq-for-woocommerce');
$view_your_cart_text =sprintf(
/* translators:link to cart wording. */
    (__('%1$s', 'woo-rfq-for-woocommerce' )),
    esc_js( $view_your_cart_text )
);
echo wp_kses_post(<<< eod
<div style="display: block"><a  class="link_to_rfq_page_link" href="$link_to_rfq_page" >$view_your_cart_text</a></div>
eod);

?>