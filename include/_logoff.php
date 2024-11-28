<?php
// Initialize the session if it hasn't been started
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != "") {
  $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_GET['doLogout']) && $_GET['doLogout'] == "true") {
  // Clear all session variables
  $_SESSION = array();
  
  // Destroy the session completely
  session_destroy();

  // Regenerate the session ID for security
  session_regenerate_id(true);

  // Redirect to the specified page after logout
  $logoutGoTo = "products.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
