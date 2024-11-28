<?php
require_once('../connections/conn.php'); 

// Start the session if not already started
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

// Check if the form is submitted
if (isset($_POST['username'])) {
  $loginUsername = $_POST['username'];
  $password = $_POST['password'];
  $MM_redirectLoginSuccess = "../products.php";
  $MM_redirectLoginFailed = "_user_login.php";
  $MM_redirecttoReferrer = true;

  // Prepare and execute the query using prepared statements
  $query = "SELECT username, password FROM users WHERE username = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $loginUsername);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Verify the password (assuming plain text comparison)
    if ($password === $row['password']) {
      // Declare session variables
      $_SESSION['MM_Username'] = $loginUsername;
      $_SESSION['MM_UserGroup'] = "";  // Assign the user group if necessary

      if (isset($_SESSION['PrevUrl']) && !empty($_SESSION['PrevUrl'])) {
        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];  
      }
      header("Location: " . $MM_redirectLoginSuccess);
    } else {
      // Redirect to login failed page if password verification fails
      header("Location: " . $MM_redirectLoginFailed);
    }
  } else {
    // Redirect to login failed page if username is not found
    header("Location: " . $MM_redirectLoginFailed);
  }

  $stmt->close();
}
?>

<style>
  main {
    background-color: peachpuff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  table {
    border-collapse: collapse;
    background: rgba(255, 255, 255, 0.5);
  }

  table, tr, td {
    border: 1px solid grey;
  }

  table td {
    padding: 5px 15px;
  }
</style>

<main>
<h2>User Login Page</h2>

<h3>This is user login as a buyer</h3>

<form action="<?php echo htmlspecialchars($loginFormAction); ?>" id="form1" name="form1" method="POST">
  <table width="500" border="1" align="center" cellpadding="4">
    <tr>
      <td width="159" align="right"><strong>Username</strong></td>
      <td width="8">&nbsp;</td>
      <td width="311" align="left"><input name="username" type="text" id="username" value="user1" required /></td>
    </tr>
    <tr>
      <td align="right"><strong>Password</strong></td>
      <td>&nbsp;</td>
      <td align="left"><input name="password" type="password" id="password" value="user1" required /></td>
    </tr>
    <tr>
      <td height="52" colspan="3" align="center">
        <input type="submit" name="button" id="button" value="Submit" />
        <input type="reset" name="button2" id="button2" value="Reset" />
      </td>
    </tr>
  </table>
</form>
<p>We have two users at the moment: user1/user1, user2/user2</p>
<p>We have one admin: admin/admin</p>
</main>
