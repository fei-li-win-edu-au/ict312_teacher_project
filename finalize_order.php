<?php
// Include necessary files and start the session
require_once('connections/conn.php');
include('include/_authen.php');

// Get the order ID from the POST request
$order_id = -1;
if (isset($_POST['order_id'])) {
    $order_id = (int)$_POST['order_id']; // Cast to integer for security
}

// Validate that the order ID exists and is currently pending
$query_check_order = "SELECT * FROM orders WHERE order_id = ? AND status = 'pending'";
$stmt = $conn->prepare($query_check_order);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 1) {
    // Order is valid and pending; proceed to finalize it
    $row_order = $order_result->fetch_assoc();

    // Calculate the total cost at purchase
    $query_calculate_total = "
        SELECT SUM(oi.quantity * p.price) AS total_at_purchase
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        WHERE oi.order_id = ?";
    $stmt = $conn->prepare($query_calculate_total);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_row = $result->fetch_assoc();
    $total_at_purchase = $total_row['total_at_purchase'];

    // Update the status to 'completed' and set the total cost at purchase
    $query_finalize_order = "
        UPDATE orders 
        SET status = 'completed', 
            total = ?, 
            order_time = NOW() 
        WHERE order_id = ?";
    $stmt = $conn->prepare($query_finalize_order);
    $stmt->bind_param("di", $total_at_purchase, $order_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to the order detail page
    header("Location: order_detail.php?order_id=" . urlencode($order_id));
    exit();
} else {
    // If the order is not found or not pending, display an error message and redirect back to products.php
    echo "<script>alert('Error: Order not found or already finalized.'); window.location.href = 'products.php';</script>";
    exit();
}

// Free result and close the connection
$order_result->free();
$conn->close();
?>
