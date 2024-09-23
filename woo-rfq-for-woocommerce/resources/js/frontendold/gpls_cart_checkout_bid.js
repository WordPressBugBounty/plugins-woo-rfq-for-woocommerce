import { __ } from '@wordpress/i18n';
import DOMPurify from 'dompurify';
const { registerPlugin } = wp.plugins;
const { ExperimentalOrderMeta } = wc.blocksCheckout;

const { extensionCartUpdate } = window.wc.blocksCheckout;

export function Gpls_cart_checkout_bid(bid_form) {

    const NPQuoteLinkBidComponent = ({checkout, extensions}) => {

        const sanitizedData = () => ({
            __html: DOMPurify.sanitize(bid_form)
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
                <NPQuoteLinkBidComponent/>
            </ExperimentalOrderMeta>
        );
    };

    registerPlugin('woo-rfq-for-woocommerce', {
        render,
        scope: 'woocommerce-checkout',
    });



}


