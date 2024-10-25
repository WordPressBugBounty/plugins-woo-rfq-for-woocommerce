<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * @author  Neah Plugins
 * @author  WooThemes

 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
do_action('gpls_woo_rfq_before_proceed_to_checkout');

$remove_totals = false;

if (get_option('settings_gpls_woo_rfq_checkout_option', 'normal_checkout') == "rfq") {
    //if (get_option('settings_gpls_woo_rfq_show_prices','no') == 'no' )
    {
        $remove_totals = true;
    }
}

if(function_exists('is_user_logged_in')) {
    if (get_option('settings_gpls_woo_rfq_hide_visitor_prices', 'no') == 'yes' && !is_user_logged_in()) {
        $remove_totals = true;
    }
}

?>

<?php if ($remove_totals == true) : ?>

    <?php

    require_once(gpls_woo_rfq_DIR . 'wp-session-manager/wp-session-manager.php');
    require_once(ABSPATH . 'wp-includes/class-phpass.php');


    $wp_session = gpls_woo_get_session();

    $gpls_woo_rfq_purchase_only = gpls_woo_rfq_get_item('gpls_woo_rfq_purchase_only');
    $is_quote_request = gpls_woo_rfq_get_item('is_quote_request');

    if($gpls_woo_rfq_purchase_only=="yes" && $is_quote_request !='yes'){
        $proceed_to_rfq = get_option('settings_gpls_woo_rfq_limit_to_rfq_only_cart_alt_label', __('Proceed to Checkout', 'woo-rfq-for-woocommerce'));
        // $proceed_to_rfq = __($proceed_to_rfq,'woo-rfq-for-woocommerce');

        $proceed_to_rfq =sprintf(
        /* translators:proceed_to_checkout label. */
            html_entity_decode(__('&#8197;%1$s', 'woo-rfq-for-woocommerce' )),
            esc_html( $proceed_to_rfq )
        );

        gpls_woo_rfq_cart_delete('gpls_woo_rfq_purchase_only');
    }else{
        $proceed_to_rfq = get_option('rfq_cart_wordings_proceed_to_rfq', __('Proceed To Submit Your RFQ', 'woo-rfq-for-woocommerce'));
        //  $proceed_to_rfq = __($proceed_to_rfq,'woo-rfq-for-woocommerce');
        $proceed_to_rfq =sprintf(
        /* translators:proceed_to_checkout label. */
            html_entity_decode(__('&#8197;%1$s', 'woo-rfq-for-woocommerce' )),
            esc_js( $proceed_to_rfq )
        );
        $proceed_to_rfq = apply_filters('gpls_woo_rfq_proceed_to_rfq', $proceed_to_rfq);
    }

    ?>
    <?php echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="checkout-button button alt wc-forward">'
        . wp_kses($proceed_to_rfq,wp_kses_allowed_html( 'post' )) . '</a>'; ?>
<?php else :
    $alternate = __('Proceed to checkout','woo-rfq-for-woocommerce');
    // $alternate = __($alternate,'woo-rfq-for-woocommerce');
    $alternate =sprintf(
    /* translators:proceed_to_checkout label. */
        html_entity_decode(__('&#8197;%1$s', 'woo-rfq-for-woocommerce' )),
        esc_js( $alternate )
    );

    ?>
    <?php echo '<a href="' . esc_url(wc_get_checkout_url())
    . '" class="checkout-button button alt wc-forward">' . wp_kses($alternate,wp_kses_allowed_html( 'post' )) . '</a>'; ?>
<?php endif; ?>


