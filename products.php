<?php
	include ("include/header_nav.php");
	include ("include/_logoff.php");
?>

<main>
	
	<div id = "search_pad">
			<form id="form1" name="form1" method="post" action="products_search.php">
			  <label>
			  <input name="keyword" type="text" id="keyword" size="15" />
			  <input type="submit" name="button" id="button" value="Search" />
			  </label>
				
			  | <?php if ( isset($_SESSION['MM_Username']) ){ ?>

				logged in as <strong><?php echo $_SESSION['MM_Username']; ?></strong> | <a href="<?php echo $logoutAction ?>" class="linkType2">log off</a> 
			 <?php }
					else {

			  ?>

			  <a href="include\_user_login.php" class="linkType2">Login</a> | <a href="_user_registration.php" class="linkType2">Register</a>
			  <?php }

			  ?>			
				
	        </form>

	</div>

	<h2>Products</h2>
	<div class="image_a">
		<div id ="category_pad">
			<h3 id="cat_title">Men</h3>
			<a href="products_cat1.php" ><img src="images/cat1.jpg" /></a>
		</div>
		<div id ="category_pad">
			<h3 id="cat_title">Women</h3>
			<a href="products_cat2.php" ><img src="images/cat2.jpg" /></a>
		</div>
	</div>

</main>

<?php
	include ("include/footer.php");
?>
