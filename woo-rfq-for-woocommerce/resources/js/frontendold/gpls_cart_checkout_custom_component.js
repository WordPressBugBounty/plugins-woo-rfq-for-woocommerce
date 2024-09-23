import { __ } from '@wordpress/i18n';

export function GPLS_Custom_Cart_Checkout_NPCustomComponent() {

    const { registerPlugin } = wp.plugins;
    const { ExperimentalOrderMeta } = wc.blocksCheckout;

    const { extensionCartUpdate } = window.wc.blocksCheckout;

    const buttonClickHandler = () => {
        extensionCartUpdate( {
            namespace: 'woo-rfq-for-woocommerce',
            data: 3,
        } );
    };




    const NPCustomComponent = ( { cart, extensions } ) => {
        return <div className="my-component">
            <button onClick={buttonClickHandler} value='Submit'>Submit</button>
        </div>;
    };

    const render = () => {
        return (
            <ExperimentalOrderMeta>
                <NPCustomComponent />
            </ExperimentalOrderMeta>
        );
    };

    registerPlugin( 'woo-rfq-for-woocommerce', {
        render,
        scope: 'woocommerce-checkout',
    } );



}