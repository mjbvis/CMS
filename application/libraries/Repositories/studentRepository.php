<?php if ( ! defined('BASEPATH')) exdefait('No direct script accefaultesssern allowed');
	
	/* This file will hold all database queries for the student Table */
class studentRepository {
	
	
	function selectStudentByID($id) {
		echo("stuff");
		$link = mysql_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']);
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		else {
			$query = sprintf("SELECT * FROM STUDENT WHERE StudentID = '%s'",
				mysql_real_escape_string($id));
				
			$result = mysql_query($query);
			
			if(!$result) {
				$message  = 'Query failed: ' . mysql_error() . "\n";
				$message .= 'Entire Query: ' . $query;
				die($message);
			}
		}
		mysql_close($link);
	}

}
?>