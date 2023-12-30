


Echo.channel("new-product-orders").listen(
    "NewProductOrderNotificationEvent",
    (e) => {
        console.log(e);
    }
);

// Listen for notifications
// window.Echo.channel("new-product-orders")
// .listen(".NewProductOrderNotificationEvent",
//     (event) => {
//         console.log(event.order);
//         swal({
//             title: "New Product Order Received",
//             text: "A new product order has been received!",
//             icon: "success",
//         });
//     }
// );
