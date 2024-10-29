<?php
// phpcs:disable WordPress.WP.I18n.NoEmptyStrings
// phpcs:disable WordPress.WP.I18n.NonSingularStringLiteralText
//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
//phpcs:disable WordPress.Security.EscapeOutput.HeredocOutputNotEscaped
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$view_your_cart_text = get_option('rfq_cart_wordings_view_rfq_cart', __('View List', 'woo-rfq-for-woocommerce'));
$view_your_cart_text = __(wp_kses_post($view_your_cart_text), 'woo-rfq-for-woocommerce');
$link_to_rfq_page = wp_kses_post($link_to_rfq_page);

echo <<< eod
<div style="display: block"><a  class="link_to_rfq_page_link" href="{$link_to_rfq_page}" >{$view_your_cart_text}</a></div>
eod;

?>