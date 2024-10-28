<?php
/**
 * Admin new RFQ email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-rfq.php.
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$plain_text = false;
$show_prices = true;
$hide_admin = false;
$text_align  = is_rtl() ? 'right' : 'left';
$margin_side = is_rtl() ? 'left' : 'right';
?>
<?php

?>
<?php do_action('woocommerce_email_header', $email_heading, $email); ?>

    <p><?php


        printf(
                /* translators:customer name label. */
            wp_kses(__('You have received an request for a quote from %s. The request is as follows:', 'woo-rfq-for-woocommerce'),
                wp_kses_allowed_html( 'post' )),
            esc_js($order->get_formatted_billing_full_name())); ?></p>

<?php do_action('woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email); ?>

    <h2><a class="link" href="<?php echo  esc_js(admin_url('post.php?post=' .  esc_js($order->get_id()) . '&action=edit')); ?>">
           


        <h2><?php printf(
            /* translators: get_order_number . */
                esc_js(__('Order #%s', 'woo-rfq-for-woocommerce')), esc_js($order->get_order_number())); ?>
        </h2>

        (<?php printf( ('<time datetime="%s">%s</time>'),  esc_js(date_i18n('c', strtotime(esc_js($order->get_date_created())))),
                esc_js(date_i18n(wc_date_format(), strtotime(esc_js($order->get_date_created()))))

            ); ?>)</h2>

    <table class="td" cellspacing="0" cellpadding="6"
           style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
        <thead>
        <tr>
            <th class="td" scope="col"
                style="text-align:<?php echo esc_attr( $text_align ); ?>;">
                <?php printf( esc_js(__('Product', 'woo-rfq-for-woocommerce'))); ?></th>
            <th class="td" scope="col"
                style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php printf(esc_js(__('Quantity', 'woo-rfq-for-woocommerce'))); ?></th>
            <th class="td" scope="col"
                style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php printf(esc_js(__('Price', 'woo-rfq-for-woocommerce'))); ?></th>


        </tr>
        </thead>
        <tbody>
        <?php


        add_filter('woocommerce_email_order_items_args', 'filter_gpls_woo_rfq_add_show_prices_to_wc_emails', 100, 1);

        gpls_woo_rfq_remove_filters_normal_checkout();

        echo wp_kses(rfqtk_get_email_order_items($order,array(
            'items' =>$order->get_items(),
            'show_sku' => true,
            'show_image' => true,
            'image_size' => array(128, 128),
            'plain_text' => $plain_text,
            'show_prices' => $show_prices,
            'sent_to_admin' => true,
            'hide_admin' => $hide_admin,

        )),wp_kses_allowed_html( 'post' ));

        ?>

        </tbody>
        <tfoot>
        <?php


        if ($totals = $order->get_order_item_totals()) {
            $i = 0;
            foreach ($totals as $total) {
                $i++;
                ?>
                <tr>
                <th class="td" scope="row" colspan="2"
                    style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php if ($i == 1) echo 'border-top-width: 4px;'; ?>"><?php echo esc_js($total['label']); ?></th>
                <td class="td"
                    style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php if ($i == 1)
                        echo 'border-top-width: 4px;'; ?>"><?php if (!$hide_admin)
                            echo wp_kses($total['value'],wp_kses_allowed_html( 'post' )); ?></td>
                </tr><?php
            }
        }


        ?>
        </tfoot>
    </table>

<?php


?>

<?php do_action('woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email); ?>


<?php do_action('woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email); ?>

<?php do_action('woocommerce_admin_email_order_meta', $order, $sent_to_admin, $plain_text, $email); ?>

<?php do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email); ?>

<?php
if ($additional_content) {
    echo wp_kses( $additional_content,wp_kses_allowed_html( 'post' ));
}
?>

<?php do_action('woocommerce_email_footer', $email); ?>

<?php gpls_woo_rfq_add_filters_normal_checkout(); ?>