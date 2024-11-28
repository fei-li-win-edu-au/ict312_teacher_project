<?php
// Include necessary files and start the session
require_once('connections/conn.php');
include('include/_authen.php');  
include("include/_logoff.php");

// Get the user's information based on the logged-in session
$colname_theUser = "-1";
if (isset($_SESSION['MM_Username'])) {
    $colname_theUser = $_SESSION['MM_Username'];
}
$query_theUser = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query_theUser);
$stmt->bind_param("s", $colname_theUser);
$stmt->execute();
$theUser = $stmt->get_result();
$row_theUser = $theUser->fetch_assoc();
$user_id = $row_theUser['user_id']; // 'user_id' is the correct column name as per the SQL schema

// Check if there's an existing pending order for the user
$query_pending_order = "SELECT * FROM orders WHERE user_id = ? AND status = 'pending'";
$stmt = $conn->prepare($query_pending_order);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$pending_order = $stmt->get_result()->fetch_assoc();
$order_id = $pending_order ? $pending_order['order_id'] : null;

// If no pending order exists, create one
if (!$order_id) {
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, 0, 'pending')");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $order_id = $stmt->insert_id; // Get the new order's ID
    $stmt->close();
}

// Only add the product to the cart if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $colname_theProduct = (int)$_POST['product_id']; // Cast to integer for security

    // Retrieve the product details based on the product ID
    $query_theProduct = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query_theProduct);
    $stmt->bind_param("i", $colname_theProduct);
    $stmt->execute();
    $theProduct = $stmt->get_result();
    $row_theProduct = $theProduct->fetch_assoc();

    $quantity = (int)$_POST['quantity']; // Ensure quantity is an integer
    $cost = $quantity * $row_theProduct['price'];

    // Insert the product into the order_items table with all necessary details
    $stmt = $conn->prepare("
        INSERT INTO order_items 
        (order_id, product_id, quantity) 
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("iii", 
        $order_id, 
        $row_theProduct['product_id'], 
        $quantity
    );
    $stmt->execute();
    $stmt->close();
}

// Fetch all items in the current pending order
$query_cart_items = "SELECT oi.order_item_id, oi.quantity, p.name, p.photo, p.price FROM order_items oi
                     JOIN products p ON oi.product_id = p.product_id
                     WHERE oi.order_id = ?";
$stmt = $conn->prepare($query_cart_items);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$cart_items = $stmt->get_result();

$total = 0;

// Fetch all completed orders for the user
$query_completed_orders = "SELECT * FROM orders WHERE user_id = ? AND status = 'completed'";
$stmt = $conn->prepare($query_completed_orders);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
$totalRows_orders = $orders->num_rows; // Number of completed orders
?>

<?php include("include/header_nav.php"); // Include the header/navigation template ?>

<main>
    <!-- Display the user's current session -->
    <p id="search_pad">Logged in as <strong><?php echo htmlspecialchars($_SESSION['MM_Username']); ?></strong></p>
    <h2>SHOPPING CART</h2>

    <!-- Display the current products in the cart -->
    <?php if ($cart_items->num_rows > 0): ?>
        <table width="100%" border="1" cellpadding="4" id="cart">
            <tr>
                <th width="160px"><strong>Product Ordered</strong></th>
                <th width="120px"><strong>Quantity</strong></th>
                <th width="160px"><strong>Unit Price</strong></th>
                <th align="right"><strong>Cost</strong></th>
                <th width="80px" align="center"><strong>Action</strong></th> <!-- Added fixed width here -->
            </tr>
            <?php while ($row_cart_item = $cart_items->fetch_assoc()): 
                $item_cost = $row_cart_item['quantity'] * $row_cart_item['price'];
                $total += $item_cost;
            ?>
            <tr>
                <td>
                    <img id="cart_image" src="images/products/<?php echo htmlspecialchars($row_cart_item['photo']); ?>" />
                    <br><?php echo htmlspecialchars($row_cart_item['name']); ?>
                </td>
                <td><?php echo htmlspecialchars($row_cart_item['quantity']); ?></td>
                <td>$<?php echo number_format($row_cart_item['price'], 2); ?></td>
                <td align="right">$<?php echo number_format($item_cost, 2); ?></td>
                <td width="80px" align="center"> <!-- Added fixed width here -->
                    <form method="post" action="delete_item.php">
                        <input type="hidden" name="order_item_id" value="<?php echo htmlspecialchars($row_cart_item['order_item_id']); ?>">
                        <button type="submit" style="display:inline;">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3" align="right"><strong>Total</strong></td>
                <td align="right">$<?php echo number_format($total, 2); ?></td>
            </tr>
            <tr>
                <td colspan="3" align="right"><strong>GST (10%)</strong></td>
                <td align="right">$<?php echo number_format($total * 0.1, 2); ?></td>
            </tr>
            <tr>
                <td colspan="3" align="right"><strong>Grand Total</strong></td>
                <td align="right">$<?php echo number_format($total * 1.1, 2); ?></td>
            </tr>
        </table>
    <?php else: ?>
        <!-- Display empty cart message -->
        <p>Your cart is now empty. <a href="products.php">Continue shopping</a>.</p>
    <?php endif; ?>

    <!-- Option to go back to shopping and finalize the order -->
    <?php if ($cart_items->num_rows > 0): ?> <!-- Hide these buttons when the cart is empty -->
        <p id="cart">
            <a href="products.php" class="linkType2">Continue Shopping</a> 
            <span>or</span>
            <form method="post" action="finalize_order.php" style="display:inline;">
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
                <button type="submit" style="display:inline; margin-left: 10px;">Finalize This Order</button>
            </form>
        </p>
    <?php endif; ?>
    <?php if ($_SESSION['MM_Username'] === 'admin') : ?>
        <p id="admin_note" style="color:red;">Since you are an admin, please try not to place orders. If you want to place an order, please log off from the <a href="products.php">Products</a> page where you can find the log-off button.<br>Then you log in from there as either user1 or user2.</p>
    <?php endif; ?>

    <!-- Display the order history -->
    <div id="order_list">
        <table width="100%" border="1" id="cart_history">
            <tr>
                <th>Order ID</th>
                <th>Date/Time</th>
                <th>Total</th>
                <th>GST</th>
                <th>Grand Total</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
            <?php if ($totalRows_orders > 0) : ?>
                <?php while ($row_orders = $orders->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row_orders['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($row_orders['order_time']); ?></td>
                        <td>$<?php echo number_format($row_orders['total'], 2); ?></td>
                        <td>$<?php echo number_format($row_orders['total'] * .1, 2); ?></td>
                        <td>$<?php echo number_format($row_orders['total'] * 1.1, 2); ?></td>
                        <td><?php echo htmlspecialchars($row_orders['status']); ?></td>
                        <td><a href="order_detail.php?order_id=<?php echo htmlspecialchars($row_orders['order_id']); ?>">View Details</a></td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7">You do not have any completed orders. Your current pending order is shown above. It will appear here after being finalized.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</main>

<?php
// Free result sets and close connections
$cart_items->free();
// Free result sets and close connections
if (isset($theProduct)) {
    $theProduct->free();
}
$orders->free();
$theUser->free();
$conn->close();

include("include/footer.php"); // Include the footer template
?>
