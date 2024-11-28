<?php
require_once('connections/conn.php');
session_start();

$order_id = $_GET['order_id'];

// Query to get the items in the specified order along with order total and order time
$query_order_items = "
    SELECT oi.*, p.*, o.total AS order_total, o.order_time AS order_time
    FROM order_items oi 
    LEFT JOIN products p ON oi.product_id = p.product_id 
    LEFT JOIN orders o ON oi.order_id = o.order_id
    WHERE oi.order_id = ?";
$stmt = $conn->prepare($query_order_items);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();


include("include/header_nav.php");
?>

<main>
    <h2>Order Details</h2>
    <table width="100%" border="1">
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Current Price</th>
            <th>Current Total</th>
        </tr>
        <?php 
        $total_current = 0;
        $total_at_purchase = 0;
        $order_time = '';

        while ($row = $result->fetch_assoc()): 
            // Track totals and order time
            $total_current += $row['quantity'] * $row['price'];
            $total_at_purchase = $row['order_total'];
            $order_time = $row['order_time']; // Assuming all items have the same order time
        ?>
            <tr>
                <td>
                    <?php 
                    if ($row['name']) {
                        echo htmlspecialchars($row['name']);
                    } else {
                        echo "Product no longer available";
                    }
                    ?>
                </td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td>
                    <?php 
                    if ($row['name']) {
                        echo "$" . number_format($row['price'], 2);
                    } else {
                        echo "N/A";
                    }
                    ?>
                </td>
                <td>
                    <?php 
                    if ($row['name']) {
                        echo "$" . number_format($row['quantity'] * $row['price'], 2);
                    } else {
                        echo "N/A";
                    }
                    ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h3>Order Summary</h3>
    <table width="100%" border="1">
        <tr>
            <th>Details</th>
            <th>Current</th>
            <th>At Purchase</th>
        </tr>
        <tr>
            <td>Total</td>
            <td>$<?php echo number_format($total_current, 2); ?></td>
            <td>$<?php echo number_format($total_at_purchase, 2); ?></td>
        </tr>
        <tr>
            <td>GST (10%)</td>
            <td>$<?php echo number_format($total_current * 0.1, 2); ?></td>
            <td>$<?php echo number_format($total_at_purchase * 0.1, 2); ?></td>
        </tr>
        <tr>
            <td>Grand Total</td>
            <td>$<?php echo number_format($total_current * 1.1, 2); ?></td>
            <td>$<?php echo number_format($total_at_purchase * 1.1, 2); ?></td>
        </tr>
        <tr>
            <td>Date/Time</td>
            <td><?php echo htmlspecialchars(date('Y-m-d H:i:s')); ?></td>
            <td><?php echo htmlspecialchars($order_time); ?></td>
        </tr>
    </table>
    <!-- Go back to Cart page button -->
    <p style="text-align: center; margin-top: 20px;">
        <a href="products_cart.php" class="linkType2">
            <button type="button">Go back to Cart page</button>
        </a>
    </p>
</main>

<?php
$stmt->close();
$conn->close();
include("include/footer.php");
?>
