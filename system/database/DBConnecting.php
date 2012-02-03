$connection = mysql_connect(
	/* Connection String */ 'http://home.justin-field.com/phpmyadmin/' 
	/* Username */ 'cms' 
	/* Password */ 'Th3.D@t@bas3.P@ssw0rd')
	or exit('Could not connect (' .mysql_errno() . '): ' .mysql_error());
