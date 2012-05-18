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
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/login/screen.css'); ?>" type="text/css"	media="screen" />
	</head>
	<body>
		<div id="login">
			<img src="<?php echo base_url('assets/images/login_banner.png'); ?>" alt="CMS Logo" width="400" height="150">
			<p>
				Please change your password before proceeding.
			</p>
			<form name="changePasswordForm" method="POST">

				<label>Password:</label>
				<input type="password" name="password" value="<?php echo set_value('password'); ?>" />
				<br />
				<?php echo form_error('password'); ?>

				<br />

				<label style="margin-right: 16px;">Confirm: </label>
				<input type="password" name="passconf" value="<?php echo set_value('passconf'); ?>" />
				<br />
				<?php echo form_error('passconf'); ?>

				<div id="bottom">
					<input type="submit" value="Submit" name="submit" class="submit"/>
					<a href="<?php echo base_url('logout'); ?>">Logout</a>
				</div>

			</form>
		</div>
	</body>
</html>