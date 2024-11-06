<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include('./db_connect.php');
?>

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Staff Forum System</title>

	<?php include('./header.php'); ?>
	<?php
	if (isset($_SESSION['login_id']))
		header("location:index.php?page=home");

	?>
</head>
<style>
	body {
		width: 100%;
		height: calc(100%);
	}

	main#main {
		width: 100%;
		height: 100vh;
		background: url('./assets/img/bg-login.jpg') no-repeat;
		background-size: cover;
		background-position: center center;
	}

	#login-right {
		position: absolute;
		right: 0;
		width: 40%;
		height: calc(100%);
		display: flex;
		align-items: center;
	}

	#login-left {
		position: absolute;
		left: 0;
		width: 60%;
		height: calc(100%);
		background: transparent;
		display: flex;
		/* align-items: center; */
	}

	#login-left h3 {
		color: #315972;
		margin: 50px 30px;
		border-bottom: 1px solid #607D8B;
		height: fit-content;
		padding: 10px 0;
	}

	#login-right .card {
		margin: auto;
		z-index: 1
	}

	.logo {
		margin: auto;
		font-size: 8rem;
		background: white;
		padding: .5em 0.7em;
		border-radius: 50% 50%;
		color: #000000b3;
		z-index: 10;
	}

	div#login-right::before {
		content: "";
		position: absolute;
		top: 0;
		left: 0;
		width: calc(100%);
		height: calc(100%);
		background: transparent;
	}

	#login-form h4,
	#login-form p {
		text-align: center;
		width: 100%;
	}
</style>

<body>

	<main id="main" class="bg-dark">
		<div id="login-left">
			<h3>Staff Forum System</h3>
		</div>

		<div id="login-right">
			<div class="card col-md-8">
				<div class="card-body">

					<form id="login-form">
						<h4>Login</h4>
						<div class="form-group">
							<label for="username" class="control-label">Username</label>
							<input type="text" id="username" name="username" class="form-control">
						</div>
						<div class="form-group">
							<label for="password" class="control-label">Password</label>
							<input type="password" id="password" name="password" class="form-control">
						</div>

						<p>No account? <a href="./signup.php">Sign up</a></p>
						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
					</form>
				</div>
			</div>
		</div>

	</main>

	<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

</body>
<script>
	$('#login-form').submit(function(e) {
		e.preventDefault();
		$('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
		if ($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();
		$.ajax({
			url: 'ajax.php?action=login',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err)
				$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success: function(resp) {
				if (resp == 1) {
					location.href = 'index.php?page=home';
				} else if (resp == 2) {
					$('#login-form').prepend('<div class="alert alert-danger">Username and password cannot be empty</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				} else {
					$('#login-form').prepend('<div class="alert alert-danger">Incorrect password</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>

</html>
