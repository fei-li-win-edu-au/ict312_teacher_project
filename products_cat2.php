<?php
require_once('connections/conn.php');
include('include/_authen.php');

// Use prepared statements for security
$stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
$category = 'F';  // Female
$stmt->bind_param("s", $category);

$stmt->execute();
$result = $stmt->get_result();

include("include/header_nav.php");
?>

<main>
    <p id="search_pad">Logged in as <?php echo htmlspecialchars($_SESSION['MM_Username']); ?></p>
    <h2>Products - Women</h2>
    <div class="image_a">
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="product-unit">
                <a href="products_detail.php?product_id=<?php echo htmlspecialchars($row['product_id']); ?>">
                    <img src="images/products/<?php echo htmlspecialchars($row['photo']); ?>" border="0" alt="<?php echo htmlspecialchars($row['name']); ?>" />
                </a>
                <p><?php echo htmlspecialchars($row['name']); ?></p>
                <p><?php echo htmlspecialchars($row['label']); ?></p>
                <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
    </div>
</main>

<?php
$stmt->close();
$conn->close();
include("include/footer.php");
?>
