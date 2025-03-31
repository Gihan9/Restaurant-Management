$(document).ready(function () {
   
   // Fetch all orders for the Orders Page
function fetchOrders() {

    $.ajax({
        url: '/api/orders',
        method: 'GET',
        success: function (response) {
            let ordersHtml = '';
            response.orders.forEach(order => {
                let sendToKitchenBtn = '';
                let deleteBtn = '';

                // Check if the order is in progress or completed
                if (order.status !== 'In-Progress' && order.status !== 'Completed') {
                    sendToKitchenBtn = `<button class="btn btn-success btn-sm send-to-kitchen" data-id="${order.id}">Send to Kitchen</button>`;
                }

                // Delete button
                deleteBtn = `<button class="btn btn-danger btn-sm delete-order" data-id="${order.id}">Delete</button>`;

                ordersHtml += `<tr>
                    <td>${order.id}</td>
                    <td>${order.concessions.map(c => `${c.name} (Qty: ${c.pivot.quantity})`).join(', ')}</td>
                    <td>${order.send_to_kitchen_time}</td>
                    <td>${order.status}</td>
                    <td>
                        ${sendToKitchenBtn} 
                        ${deleteBtn}  <!-- Delete Button -->
                    </td>
                </tr>`;
            });

            $('#orders-table tbody').html(ordersHtml);
        },
        error: function (error) {
            console.error('Error fetching orders:', error);
        }
    });
}


    // Fetch kitchen orders (only those ready to be prepared)
    function fetchKitchenOrders() {

        $.ajax({
            url: '/api/orders/update-status',
            method: 'POST',
            success: function () {
                console.log('Orders updated');
            },
            error: function (error) {
                console.error('Error updating orders:', error);
            }
        });
        
        $.ajax({
            url: '/api/kitchen/orders',
            method: 'GET',
            success: function (response) {
                let kitchenHtml = '';
                const currentTime = new Date();

                response.orders.forEach(order => {
                    const orderTime = new Date(order.send_to_kitchen_time);

                    if (orderTime <= currentTime || order.status === 'In-Progress') { 
                        let completeOrderBtn = '';
                        // Show the "Complete" button only when the order is in progress
                        if (order.status === 'In-Progress') {
                            completeOrderBtn = `<button class="btn btn-success btn-sm complete-order" data-id="${order.id}">Complete</button>`;
                        }

                        kitchenHtml += `<tr>
                            <td>${order.id}</td>
                            <td>${order.concessions.map(c => `${c.name} (Qty: ${c.pivot.quantity})`).join(', ')}</td>
                            <td>${order.concessions.reduce((total, c) => total + (c.price * c.pivot.quantity), 0)}</td>
                            <td>${order.status}</td>
                            <td>
                                ${completeOrderBtn}
                            </td>
                        </tr>`;
                    }
                });

                $('#kitchen-orders-table tbody').html(kitchenHtml);
            },
            error: function (error) {
                console.error('Error fetching kitchen orders:', error);
            }
        });
    }

    // Send an order to the kitchen
    $(document).on('click', '.send-to-kitchen', function () {
        const orderId = $(this).data('id');
        $.ajax({
            url: `/api/orders/send-to-kitchen/${orderId}`,
            method: 'POST',
            success: function () {
                alert('Order sent to the kitchen!');
                fetchOrders(); // Refresh orders list
                fetchKitchenOrders(); // Refresh kitchen orders list
            },
            error: function (error) {
                console.error('Error sending order:', error);
            }
        });
    });

    // Complete a kitchen order
    $(document).on('click', '.complete-order', function () {
        const orderId = $(this).data('id');
        $.ajax({
            url: `/api/kitchen/orders/complete/${orderId}`,
            method: 'POST',
            success: function () {
                alert('Order completed!');
                fetchKitchenOrders(); // Refresh kitchen orders list
            },
            error: function (error) {
                console.error('Error completing order:', error);
            }
        });
    });

     // Delete a kitchen order
    $(document).on('click', '.delete-order', function () {
        const orderId = $(this).data('id');
        const confirmation = confirm('Are you sure you want to delete this order?');
    
        if (confirmation) {
            $.ajax({
                url: `/api/orders/${orderId}`,
                method: 'DELETE',
                success: function (response) {
                    alert(response.message); 
                    fetchOrders(); // Refresh orders list
                },
                error: function (error) {
                    console.error('Error deleting order:', error);
                }
            });
        }
    });

    // Automatically refresh orders and kitchen orders every 10 seconds
    setInterval(fetchOrders, 10000);
    setInterval(fetchKitchenOrders, 10000);

    // Initial data load
    fetchOrders();
    fetchKitchenOrders();
});
