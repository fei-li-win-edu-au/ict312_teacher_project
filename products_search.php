<?php require_once('connections/conn.php'); ?>
<?php

$colname_ProductsSearch = "-1";
if (isset($_POST['keyword'])) {
    $colname_ProductsSearch = $_POST['keyword'];
}

$query_ProductsSearch = "SELECT * FROM products WHERE name LIKE ?";
$stmt = $conn->prepare($query_ProductsSearch);
$searchTerm = "%" . $colname_ProductsSearch . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$ProductsSearch = $stmt->get_result();
$totalRows_ProductsSearch = $ProductsSearch->num_rows;

?>

<?php include ("include/header_nav.php"); ?>
<main class="image_a">
    <div id="search_pad">
        <form id="form1" name="form1" method="post" action="products_search.php">
            <label>
                <input name="keyword" type="text" id="keyword" size="15" />
                <input type="submit" name="button" id="button" value="Search" />
            </label>
        </form>
    </div>
    <h2>Products - Search Result</h2>
    
    <?php
    while ($row_ProductsSearch = $ProductsSearch->fetch_assoc()) {
        ?>
        <div id="search_result_pad">
            <a href="products_detail.php?product_id=<?php echo htmlspecialchars($row_ProductsSearch['product_id']); ?>">
                <img width="120px" src="images/products/<?php echo htmlspecialchars($row_ProductsSearch['photo']); ?>" border="0" alt="<?php echo htmlspecialchars($row_ProductsSearch['name']); ?>" />
            </a>
            <br><?php echo htmlspecialchars($row_ProductsSearch['name']); ?>
        </div>
        <?php
    }
    ?>
    
    <?php
    $ProductsSearch->free(); // Corrected to free() for object-oriented style
    $stmt->close();
    $conn->close();
    ?>

</main>

<?php include ("include/footer.php"); ?>
