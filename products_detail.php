<?php 
require_once('connections/conn.php'); 
include('include/_authen.php'); 

// Retrieve the product ID from the URL and cast it to an integer for security
$product_id = -1;
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
}

// Prepare and execute the query to fetch product details
$query_theProduct = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query_theProduct);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$theProduct = $stmt->get_result();
$row_theProduct = $theProduct->fetch_assoc();

include("include/header_nav.php"); 
?>

<main>
    <p id="search_pad">Logged in as <?php echo htmlspecialchars($_SESSION['MM_Username']); ?></p>
    <h2>Product Detail</h2>
    
    <!-- Display the product details -->
    <img id="p_detail_img" src="images/products/<?php echo htmlspecialchars($row_theProduct['photo']); ?>" alt="<?php echo htmlspecialchars($row_theProduct['name']); ?>" />

    <div id="p_detail_pad">
        <p>
          <strong>Name:</strong> <?php echo htmlspecialchars($row_theProduct['name']); ?><br />
          <strong>Label:</strong> <?php echo htmlspecialchars($row_theProduct['label']); ?><br />
          <strong>Category:</strong> <?php echo htmlspecialchars($row_theProduct['category']); ?> -- Gender<br />
          <strong>Attribute1:</strong> <?php echo htmlspecialchars($row_theProduct['attribute1']); ?> --Size<br />
          <strong>Price:</strong> $<?php echo htmlspecialchars($row_theProduct['price']); ?><br />
          <strong>Description:</strong> <?php echo htmlspecialchars($row_theProduct['description']); ?>
        </p>

        <!-- Form to add the product to the cart -->
        <form id="form2" name="form2" method="post" action="products_cart.php">
            <p>
              <strong>Quantity:</strong> 
              <input name="quantity" type="number" id="quantity" min="1" required style="width: 4em;" value="1" />
              <input type="submit" name="button2" id="button2" value="Add to Cart" />
              <input name="product_id" type="hidden" id="product_id" value="<?php echo htmlspecialchars($row_theProduct['product_id']); ?>" />
            </p>
        </form>
    </div>
</main>

<?php 
// Free the result set and close the database connection
$theProduct->free(); 
$stmt->close();
$conn->close();

include("include/footer.php"); 
?>
