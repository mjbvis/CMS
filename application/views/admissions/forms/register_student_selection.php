
<div class="formBox">
	<form id="studentRegistrationSelector">
		<fieldset>
			<legend>
                currently waitlisted students:
            </legend>
			
	    	<?php
	    	foreach($wlStudents as $wlStud):
				$wlStudAttr = $wlStud->attributes();
				
				// assemble full name
				$fullname = $wlStudAttr['firstname'];
				if(!empty($wlStudAttr['middlename'])){
					$fullname = $fullname . " " . $wlStudAttr['middlename'];
				}
				$fullname = $fullname . " " . $wlStudAttr['lastname'];
				
				printf('<a href=%s>%s</a></br>', base_url('admissions/registerStudent/' . $wlStudAttr['formid']), $fullname);
			endforeach;
			?>
	    </fieldset>
    </form>
</div>