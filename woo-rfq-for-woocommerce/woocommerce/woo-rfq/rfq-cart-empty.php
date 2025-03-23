<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/woo-rfq/rfq-cart-empty.php.
 *

 */
// phpcs:ignoreFile
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if(!isset($confirmation_message) || is_admin())return;

?>
<div style="clear:both; ">
<p class="cart-empty">
	<h3>

        <?php
        $quote_request_empty = get_option('rfq_cart_wordings_quote_request_currently_empty', __('Your Quote Request List is Currently Empty.', 'woo-rfq-for-woocommerce'));

        echo ($quote_request_empty);
        ?>

    </h3>
</p>


<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<p class="rfq-return-to-shop">
		<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php
            $return_to_shop = get_option('rfq_cart_wordings_return_to_shop', __('Return To Shop', 'woo-rfq-for-woocommerce'));

            echo ($return_to_shop);

            ?>
		</a>
	</p>
<?php endif; ?>


</div>
    <div style="clear: both"></div>

<?php


?>