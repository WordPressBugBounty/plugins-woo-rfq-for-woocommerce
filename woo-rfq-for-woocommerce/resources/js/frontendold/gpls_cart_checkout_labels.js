import { __ } from '@wordpress/i18n';
import DOMPurify from 'dompurify';
import {Gpls_cart_checkout_bid} from "./gpls_cart_checkout_bid";


export function GPLS_Custom_Cart_Checkout_Labels() {

    const {registerCheckoutFilters} = window.wc.blocksCheckout;
    const { __ } = window.wp.i18n;
    const { registerPlugin } = window.wp.plugins;
    const { ExperimentalOrderMeta } = window.wc.blocksCheckout;

    let submit_label = "";
    let proceed_to_checkout_label = "";
    let quote_link = '';
    let rfq_mode=false;
    let bid_form='';

    jQuery.ajax({
        async: false,
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php", //this is wordpress ajax file which is already avaiable in wordpress
        data: {
            action: 'gplswoo_get_submit_order_label', //this value is first parameter of add_action

        },
        success: function (resp) {

            submit_label = resp['rfq_cart_wordings_submit_your_rfq_text'];
            proceed_to_checkout_label = resp['rfq_cart_wordings_proceed_to_rfq'];
            quote_link=resp['rfq_cart_link_quote'];
            rfq_mode=resp['rfq_checkout_mode'];
            bid_form=resp['rfq_cart_bid'];

            console.log(resp);
        }
    });

    const modifyProceedToCheckoutButtonLabel = (
        defaultValue,
        extensions,
        args
    ) => {
        if (!args?.cart.items) {
            return defaultValue;
        }

        return proceed_to_checkout_label;
    };

    if (rfq_mode ==="rfq") {

        registerCheckoutFilters('woo-rfq-for-woocommerce', {
            proceedToCheckoutButtonLabel: modifyProceedToCheckoutButtonLabel,
        });

        registerCheckoutFilters("woo-rfq-for-woocommerce", {
            placeOrderButtonLabel: (e, t) => submit_label,

        });

    }

    if (rfq_mode ==="normal_checkout") {
        const NPQuoteLinkComponent = ({cart, extensions}) => {

            const sanitizedData = () => ({
                __html: DOMPurify.sanitize(quote_link)
            })

            return (
                <div
                    dangerouslySetInnerHTML={sanitizedData()}
                />
            );
        };


        const render = () => {
            return (
                <ExperimentalOrderMeta>
                    <NPQuoteLinkComponent/>
                </ExperimentalOrderMeta>
            );
        };

        registerPlugin('woo-rfq-for-woocommerce', {
            render,
            scope: 'woocommerce-checkout',
        });
    }
}