<?php
	include ("include/header_nav.php");
?>

<main id = "index_main">
	<h2 id = "h2_main">Welcome Page</h2>
	<div id = "main_img_container">
		<img id = "welcome_main" src="images/welcome/welcome.jpg" width="100%" 
		/>

		<div id="welcome_message">
			<h3>Welcome to Fashionwave</h3>
			<p>Welcome to Fashionwave, where fashion meets elegance. Our carefully curated selection brings together the best of classic and contemporary styles for both men and women. Each piece in our collection is designed with attention to detail, ensuring that you feel confident and stylish, no matter the occasion.</p>
			<p>Whether you're looking for sophisticated business attire, casual weekend wear.</p>
			<p>Explore our collections today and find your perfect look with <a href="#">Fashionwave</a>.</p>

			<input type="button" value="We have done the hard work" id ="welcome-message-btn" >
		</div>
	</div>

	<img id = "welcome_small" src="images/welcome/welcome_small1.jpg" width="25%"
	/><img id = "welcome_small" src="images/welcome/welcome_small2.jpg" width="25%"
	/><img id = "welcome_small" src="images/welcome/welcome_small3.jpg" width="25%"
	/><img id = "welcome_small" src="images/welcome/welcome_small4.jpg" width="25%" />

</main>

<?php
	include ("include/footer.php");
?>