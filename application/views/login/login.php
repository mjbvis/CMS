<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="Robots" content="noindex, nofollow, noarchive">
		<meta name="Description" content="Corvallis Montessori School">
		<meta name="Author" content="Corvallis Montessori School">
		<meta name="Rating" content="General">
		<title>login | CMS</title>
		<link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/login/screen.css'); ?>" type="text/css"	media="screen" />
	</head>
	<body>
		<div id="login">
				<form name="loginform" method="POST">
					<label>Username: </label>
						<input type="text" name="username" value="<?php echo set_value('username'); ?>" /><?php echo form_error('username'); ?><br /><br />
					<label>Password:  </label>
						<input type="password" name="password" value="<?php echo set_value('password'); ?>" /><?php echo form_error('password'); ?><br /><br />
						<input type="submit" value="Login" name="submit" class="submit"/>
				</form>
		</div>
	</body>
</html>