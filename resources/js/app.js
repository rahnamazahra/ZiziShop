import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const app = new Vue({
    el: "#app",
    data: {
        messages: [],
    },

    created() {

        Echo.private("new-product-orders").listen(
            ".NewProductOrderNotificationEvent",
            (event) => {
                console.log(event.order);
                swal({
                    title: "New Product Order Received",
                    text: "A new product order has been received!",
                    icon: "success",
                });
            }
        );
    },
});
