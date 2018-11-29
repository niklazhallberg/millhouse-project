<?php
include '../includes/head.php';
?>

<body>
	<?php include '../includes/header.php'; ?>

<div class="container">

	<main class="row justify-content-center">

			<div class="col-12 col-md-4 register-box">

				<h3>Welcome to Millhouse</h3>

				<p class="error-message">
					<?php if (isset($_GET["error"])){
   					echo $_GET["error"];
 					} ?> </p>

			<form action="../includes/login_sql.php" method="POST">
  				<p>Username</p>
  				<input type="text" name="username" required>

  				<p>Password</p>
  				<input type="password" name="password" required><br>
  				<input type="submit" value="Login">
			</form>

			<a href="register.php">Not already a member? Register here</a>

		</div>

	</main>



</div>

 <?php include '../includes/javascript_tag.php'; ?>

</body>

</html>
