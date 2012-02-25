<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div class="formBox">
				<form method="post" id="registerUser">
				    <fieldset>
				    <legend><h2>Register a new parent account</h2></legend>
    					First Name: <input type="text" name="username" size="50" class="form" value="<?php echo set_value('first'); ?>" /><br /><?php echo form_error('first'); ?><br />
    					Last Name: <input type="text" name="username" size="50" class="form" value="<?php echo set_value('last'); ?>" /><br /><?php echo form_error('last'); ?><br />
    					
    					Email:<br />
    					<input type="text" name="email" size="50" class="form" value="<?php echo set_value('email'); ?>" /><?php echo form_error('email'); ?><br /><br />
    					<input type="submit" value="Register" name="register" />
					</fieldset>
				</form>
		</div>
	</body>
</html>