import Echo from "laravel-echo";
import swal from "sweetalert2";

window.Echo.channel("orders").listen("OrderCreatedEvent", (e) => {
    // Display a SweetAlert notification
    swal.fire({
        title: "New Order Created",
        text: `Order ID: ${e.order.id}`,
        icon: "success",
    });
});
