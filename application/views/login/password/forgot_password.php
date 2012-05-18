<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="Robots" content="noindex, nofollow, noarchive">
		<meta name="Description" content="Corvallis Montessori School">
		<meta name="Author" content="Corvallis Montessori School">
		<meta name="Rating" content="General">
		<title>Change Your Password | CMS</title>
		<link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/login/screen.css'); ?>" type="text/css"  media="screen" />
	</head>
	<body>
		<div id="login">
			<img src="<?php echo base_url('assets/images/login_banner.png'); ?>" alt="CMS Logo" width="400" height="150">
			<p>
				If you forgot your password, please enter your username below.
				<br />
				<br>
				We will reset your password and email your account info.
			</p>
			<form name="forgotPasswordForm" method="POST">

				<label>Username: </label>
				<input type="text" name="username" value="<?php echo set_value('username'); ?>" />
				<br />
				<?php echo form_error('username'); ?>

				<br />

				<div id="bottom">
					<input type="submit" value="Submit" name="submit" class="submit"/>
					<a href="<?php echo base_url('login'); ?>">Go back</a>
				</div>

			</form>
		</div>
	</body>
</html>