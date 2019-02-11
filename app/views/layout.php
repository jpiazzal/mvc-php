<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>MyApp</title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

		<!-- Our CSS -->
		<link href="css/style.css" rel="stylesheet">
		<!-- Our JavaScript -->
		<script src="js/script.js"></script>

	</head>

	<body>

		<!-- Navigation -->
		<?php
		if (!file_exists(CURR_VIEW_PATH . 'navbar.php')) {
			require(VIEW_PATH . 'home/navbar.php');
		} else {
			require(CURR_VIEW_PATH . 'navbar.php');
		}
		?>

		<!-- Page Content -->
		<div style="margin-top: 5rem!important;" class="container">
			<?=$content ?>
		</div>
		<!-- /.container -->

		<!-- Footer -->
		<footer class="py-3 bg-dark">
			<div class="container">
				<p class="m-0 text-center text-white">MyApp</p>
			</div>
			<!-- /.container -->
		</footer>

		<!-- Bootstrap core JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	</body>

</html>
