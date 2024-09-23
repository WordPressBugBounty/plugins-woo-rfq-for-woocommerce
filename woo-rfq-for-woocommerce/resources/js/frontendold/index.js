
import { sprintf, __ } from '@wordpress/i18n';
import { registerPaymentMethod } from '@woocommerce/blocks-registry';
import { decodeEntities } from '@wordpress/html-entities';
import { getSetting } from '@woocommerce/settings';
//import {GPLS_Custom_Cart_Checkout_Labels} from './gpls_cart_checkout_labels';
//import  {Gpls_Cart_Checkout_Link_To_Quote} from './gpls_cart_checkout_link_to_quote'
import { useEffect, useState, useCallback } from '@wordpress/element';
import { SelectControl, TextareaControl } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import DOMPurify from "dompurify";


const settings = getSetting( 'gpls-rfq_data', {} );


const defaultLabel = __(
	'Quote Request',
	'woo-rfq-for-woocommerce'
);

const label = decodeEntities( settings.title ) || defaultLabel;
const Label = ( props ) => {
	const { PaymentMethodLabel } = props.components;
	return <PaymentMethodLabel text={ label } />;
};





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

		//console.log(resp);
	}
});





//====================================================================

export function GPLS_Custom_Cart_Checkout_Labels() {

	const {registerCheckoutFilters} = window.wc.blocksCheckout;
	const { __ } = window.wp.i18n;
	const { registerPlugin } = window.wp.plugins;
	const { ExperimentalOrderMeta } = window.wc.blocksCheckout;

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
GPLS_Custom_Cart_Checkout_Labels();
//======================================================================


//=====================================================================
export function Gpls_cart_checkout_bid() {
	const {registerCheckoutFilters} = window.wc.blocksCheckout;
	const { __ } = window.wp.i18n;
	const { registerPlugin } = window.wp.plugins;
	const { ExperimentalOrderMeta } = window.wc.blocksCheckout;

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
Gpls_cart_checkout_bid();
//===============================================================

/**
 * Content component
 */
/*const Content = () => {
	return decodeEntities( settings.description || '' );
};*/


const Content = ( props ) => {
	const { eventRegistration, emitResponse } = props;
	const { onPaymentSetup } = eventRegistration;
	useEffect( () => {
		const unsubscribe = onPaymentSetup( async () => {
			// Here we can do any processing we need, and then emit a response.
			// For example, we might validate a custom field, or perform an AJAX request, and then emit a response indicating it is valid or not.
			const myGatewayCustomData = '12345';
			const customDataIsValid = !! myGatewayCustomData.length;

			if ( 1 ) {
				return {
					type: emitResponse.responseTypes.SUCCESS,
					meta: {
						paymentMethodData: {
							myGatewayCustomData,
						},
					},
				};
			}

			return {
				type: emitResponse.responseTypes.ERROR,
				message: 'There was an error',
			};
		} );
		// Unsubscribes when this component is unmounted.
		return () => {
			unsubscribe();
		};
	}, [
		emitResponse.responseTypes.ERROR,
		emitResponse.responseTypes.SUCCESS,
		onPaymentSetup,
	] );
	return decodeEntities( settings.description || '' );
};


/**
 * payment method config object.
 */
const gpls_rfq = {
	name: "gpls-rfq",
	label: <Label />,
	content: <Content />,
	edit: <Content />,
	canMakePayment: () => true,
	ariaLabel: label,
	supports: {
		features: settings.supports,
	},
};

registerPaymentMethod( gpls_rfq );
