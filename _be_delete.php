<?php 
require_once('connections/conn.php'); 
?>

<?php
// Deletion code is present but disabled for this exercise.
// Uncomment the following block if you want to enable deletion functionality in the future.

/*
if ((isset($_GET['product_id'])) && ($_GET['product_id'] != "")) {
    $deleteSQL = "DELETE FROM products WHERE product_id = ?";
    
    // Prepare and execute the delete statement
    $stmt = $conn->prepare($deleteSQL);
    $stmt->bind_param("i", $_GET['product_id']);
    $stmt->execute();
    $stmt->close();

    // Redirect to the backend interface page after deletion
    $deleteGoTo = "_be_interface.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
        $deleteGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $deleteGoTo));
    exit(); // Ensure the script stops after the redirect
}
*/

?>

<?php
include ("include/header_nav.php");
?>

<main class="backend">
    <h2>Delete Page</h2>
    <p>This page contains delete code, but it is currently disabled. This exercise does not require deletion functionality.</p>
    <p>Go back to the <a href="_be_interface.php">Backend Interface page</a></p>
</main>

<?php
include ("include/footer.php");
?>
