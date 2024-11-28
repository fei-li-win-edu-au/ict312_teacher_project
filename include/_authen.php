<?php
// Start the session if it's not already started
if (!isset($_SESSION)) {
  session_start();
}

// Restrict access to the page: Grant or deny access based on the username
function isAuthorized($authorizedUsers, $userName) { 
  // Assume the visitor is not authorized
  $isValid = false; 

  // Check if the user is logged in
  if (!empty($userName)) { 
    // Parse the list of authorized users into an array
    $arrUsers = explode(",", $authorizedUsers);

    // Check if the logged-in user is in the list of authorized users
    if (in_array($userName, $arrUsers) || empty($authorizedUsers)) { 
      $isValid = true; 
    }
  }
  return $isValid; 
}

// Redirect to login page if the user is not authorized
$MM_restrictGoTo = "include/_user_login.php";
if (!isset($_SESSION['MM_Username']) || !isAuthorized("", $_SESSION['MM_Username'])) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];

  // Check if there's a query string to append to the referrer URL
  if (strpos($MM_restrictGoTo, "?") !== false) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) {
    $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  }
  $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: " . $MM_restrictGoTo); 
  exit;
}
?>
