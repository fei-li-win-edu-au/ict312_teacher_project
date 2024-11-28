<?php

if($_SESSION['MM_Username'] != "admin"){

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


<?php
  echo "<p>You are not logged in as an admin.</p>";
  echo "<p>Please go <a href = 'include/_user_login.php'>log in as admin</a></p>";
  exit();
}
else{
  echo "<p style = 'text-align: right'>logged in as <strong style='color: red'>" . $_SESSION['MM_Username'] . "</strong></p>";


}
?>

</main>