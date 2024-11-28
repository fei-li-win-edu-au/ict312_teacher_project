<?php 
require_once('connections/conn.php'); 
include('include/_authen.php'); 
include('include/_authen_admin.php'); 

// Determine the form action URL, including any existing query strings
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// Check if the form has been submitted for updating a product
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

  // Prepare the SQL statement for updating the product in the database
  $updateSQL = $conn->prepare("UPDATE products SET photo=?, price=?, name=?, label=?, description=?, category=?, attribute1=? WHERE product_id=?");
  $updateSQL->bind_param("sdsdsssi", 
                         $_POST['photo'], 
                         $_POST['price'], 
                         $_POST['name'], 
                         $_POST['label'], 
                         $_POST['description'], 
                         $_POST['category'],  // For now, this represents gender: M - Male, F - Female
                         $_POST['attribute1'],  // For now, this represents size: M - Medium, L - Large, S - Small
                         $_POST['product_id']);
  
  // Execute the update statement and check for errors
  if (!$updateSQL->execute()) {
    die("Error executing update statement: " . $updateSQL->error);
  }
  $updateSQL->close(); // Close the prepared statement

  // Redirect back to the backend interface page after update
  $updateGoTo = "_be_interface.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
  exit(); // Ensure the script stops after the redirect
}

// Get the product ID from the URL and retrieve the product details from the database
$colname_theProduct = "-1";
if (isset($_GET['product_id'])) {
  $colname_theProduct = $_GET['product_id'];
}
$conn->select_db($database);
$query_theProduct = sprintf("SELECT * FROM products WHERE product_id = %s", $conn->real_escape_string($colname_theProduct));
$theProduct = $conn->query($query_theProduct);
$row_theProduct = $theProduct->fetch_assoc();
?>

<?php include ("include/header_nav.php"); ?>

<main class="backend">
    <h2>Backend Update Page</h2>
    <p>This page allows you to update an existing product.</p>
  
    <p><a href="_be_interface.php">Go back to Backend Interface page </a></p>
  
    <!-- Form for updating the product details -->
    <form action="<?php echo htmlspecialchars($editFormAction); ?>" id="form1" name="form1" method="POST">
        <table width="500" border="1" align="center" cellpadding="4">
            <tr>
                <td width="153" align="right">Name</td>
                <td width="3">&nbsp;</td>
                <td width="304">
                    <input name="name" type="text" id="name" value="<?php echo htmlspecialchars($row_theProduct['name']); ?>" required />
                    <input name="product_id" type="hidden" id="product_id" value="<?php echo htmlspecialchars($row_theProduct['product_id']); ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">Label</td>
                <td>&nbsp;</td>
                <td><input name="label" type="text" id="label" value="<?php echo htmlspecialchars($row_theProduct['label']); ?>" size="35" required /></td>
            </tr>
            <tr>
                <td align="right">Category</td> <!-- For now, this represents gender: M - Male, F - Female -->
                <td>&nbsp;</td>
                <td>
                    <select name="category" id="category">
                        <option value="M" <?php if ($row_theProduct['category'] == "M") echo "selected"; ?>>M</option>
                        <option value="F" <?php if ($row_theProduct['category'] == "F") echo "selected"; ?>>F</option>
                    </select>
                    -- Gender (M-male; F-female) <br>change this is not recommended
                </td>
            </tr>
            <tr>
                <td align="right">Attribute1</td> <!-- For now, this represents size: M - Medium, L - Large, S - Small -->
                <td>&nbsp;</td>
                <td>
                    <select name="attribute1" id="attribute1">
                        <option value="M" <?php if ($row_theProduct['attribute1'] == "M") echo "selected"; ?>>M</option>
                        <option value="L" <?php if ($row_theProduct['attribute1'] == "L") echo "selected"; ?>>L</option>
                        <option value="S" <?php if ($row_theProduct['attribute1'] == "S") echo "selected"; ?>>S</option>
                    </select>
                    -- Size (L-large; M-Medium; S-small)
                </td>
            </tr>
            <tr>
                <td align="right">Photo</td>
                <td>&nbsp;</td>
                <td><input name="photo" type="text" id="photo" value="<?php echo htmlspecialchars($row_theProduct['photo']); ?>" size="20" required /></td>
            </tr>
            <tr>
                <td align="right">Price</td>
                <td>&nbsp;</td>
                <td><input name="price" type="number" id="price" value="<?php echo htmlspecialchars($row_theProduct['price']); ?>" size="6" step="0.01" required /></td>
            </tr>
            <tr>
                <td align="right">Description</td>
                <td>&nbsp;</td>
                <td><textarea name="description" cols="35" rows="6" id="description" required><?php echo htmlspecialchars($row_theProduct['description']); ?></textarea></td>
            </tr>
            <tr>
                <td height="64" colspan="3" align="center">
                    <input type="submit" name="button" id="button" value="Submit" />
                    <input type="reset" name="button2" id="button2" value="Reset" />
                </td>
            </tr>
        </table>
  
        <!-- Hidden input to confirm the form submission -->
        <input type="hidden" name="MM_update" value="form1" />
    </form>
</main>

<?php 
// Free the result set and close the database connection
$theProduct->free(); // Corrected to free() to match object-oriented style
$conn->close(); // Close the database connection
include ("include/footer.php"); 
?>
