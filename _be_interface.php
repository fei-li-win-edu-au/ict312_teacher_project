<?php 
require_once('connections/conn.php'); 
include('include/_authen.php'); 
include('include/_authen_admin.php'); 

// Query the database to retrieve all products, ordered by category and product ID
$query_allProducts = "SELECT * FROM products ORDER BY category DESC, product_id DESC";
$allProducts = $conn->query($query_allProducts) or die($conn->error);
$row_allProducts = $allProducts->fetch_assoc();
$totalRows_allProducts = $allProducts->num_rows;

include("include/header_nav.php"); 
?>

<main class="backend">
    <h2>Backend Interface</h2>
    <p>This is the page to use the database</p>

    <!-- Link to insert a new product record -->
    <p><a href="_be_insert.php">Insert a new product</a></p>
    <table width="100%" border="1" cellpadding="6">
        <tr>
            <td><strong>Name</strong></td>
            <td><strong>Photo</strong></td>
            <td><strong>Category (Gender)</strong></td> <!-- For now, this represents gender: M - Male, F - Female -->
            <td><strong>Attribute1 (Size)</strong></td> <!-- For now, this represents size: M - Medium, L - Large, S - Small -->
            <td><strong>Price</strong></td>
            <td><strong>Actions</strong></td>
        </tr>
        <?php do { ?>
        <tr>
            <td><?php echo htmlspecialchars($row_allProducts['name']); ?></td>
            <td><img id="be_image" src="images/products/<?php echo htmlspecialchars($row_allProducts['photo']); ?>" /></td>
            <td><?php echo htmlspecialchars($row_allProducts['category']); ?></td>
            <td><?php echo htmlspecialchars($row_allProducts['attribute1']); ?></td>
            <td>$<?php echo number_format($row_allProducts['price'], 2); ?></td>
            <td>
                <a href="_be_delete.php?id=<?php echo htmlspecialchars($row_allProducts['product_id']); ?>">Delete</a> | 
                <a href="_be_update.php?product_id=<?php echo htmlspecialchars($row_allProducts['product_id']); ?>">Update</a>
            </td>
        </tr>
        <?php } while ($row_allProducts = $allProducts->fetch_assoc()); ?>
    </table>
</main>

<?php 
$allProducts->free(); // Free the result set
$conn->close(); // Close the database connection for good practice
include("include/footer.php"); 
?>
