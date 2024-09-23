import { __ } from '@wordpress/i18n';
import DOMPurify from 'dompurify';


export function Gpls_Cart_Checkout_Link_To_Quote() {

    const { __ } = window.wp.i18n;
    const { registerPlugin } = window.wp.plugins;
    const { ExperimentalOrderMeta } = window.wc.blocksCheckout;

    const NPQuoteLinkComponent = (quote_link ) => {

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
                <NPQuoteLinkComponent />
            </ExperimentalOrderMeta>
        );
    };

    registerPlugin('woo-rfq-for-woocommerce', {
        render,
        scope: 'woocommerce-checkout',
    } );



}


