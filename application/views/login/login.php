<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="Robots" content="noindex, nofollow, noarchive">
		<meta name="Description" content="Corvallis Montessori School">
		<meta name="Author" content="Corvallis Montessori School">
		<meta name="Rating" content="General">
		<title>login | CMS</title>
		<link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/login/screen.css');?>" type="text/css"	media="screen" />
	</head>
	<body>
		<div id="login">
			<img src="<?php echo base_url('assets/images/login_banner.png');?>" alt="CMS Logo" width="400" height="150">
			<form name="loginform" method="POST">
				<label>Username: </label>
				<?php echo form_error('username'); ?>
				<input type="text" name="username" value="<?php echo set_value('username');?>" /><br />
				<br />
				<label>Password: </label>
				<?php echo form_error('password'); ?>
				<input type="password" name="password" /><br />
				<div id="bottom">
					<input type="submit" value="Login" name="submit" class="submit"/>
					<a href="<?php echo base_url('login/forgotPass');?>">Lost your password?</a>
				</div>
			</form>
		</div>
	</body>
</html>