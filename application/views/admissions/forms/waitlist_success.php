<div id="centeredBox">
	<?php
		// assemble full name
		$fullname = $firstName;
		if(!empty($middleName)){
			$fullname = $fullname . " " . $middleName;
		}
		$fullname = $fullname . " " . $lastName;
		printf('%s has been successfully waitlisted.', $fullname)
	?>	
</div>