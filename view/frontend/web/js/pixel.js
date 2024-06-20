define([
    'Magento_Customer/js/customer-data',
], function (customerData) {
    'use strict';

    return function (config) {

        const cart = customerData.get("cart");
        const customer = customerData.get("customer");

        cart.subscribe((newCart) => {
            // @todo: we need anther tracking api to cover async changes
        })

        customer.subscribe((newCustomer) => {
            // @todo: we need anther tracking api to cover async changes
        })

        const sctp = cart()?.subtotalAmount || ""
        const cid = customer()?.admetrics?.id || ""

        config.scripts.forEach(script => {
            const element = document.createElement("script")
            for (const [key, value] of Object.entries(script.attributes)) {
                element.setAttribute(key, value)
            }

            if (script.inline) {
                element.innerText = script.inline.replace("{SCTP}", sctp).replace("{CID}", cid)
            }

            document.body.appendChild(element)
        })
    };
});
