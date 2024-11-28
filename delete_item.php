<?php
require_once('connections/conn.php');

// Get the order_item_id from the POST request
$order_item_id = (int)$_POST['order_item_id'];

// Prepare and execute the deletion query
$query_delete_item = "DELETE FROM order_items WHERE order_item_id = ?";
$stmt = $conn->prepare($query_delete_item);
$stmt->bind_param("i", $order_item_id);
$stmt->execute();

// Redirect back to the cart page
header("Location: products_cart.php");
exit();
?>
