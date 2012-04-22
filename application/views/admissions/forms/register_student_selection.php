
<div class="formBox">
	<form id="studentRegistrationSelector">
		<fieldset>
			<legend>
                Pre-enrolled Students:
            </legend>
			
	    	<?php
	    	foreach($preEnStudents as $peStud):
				$peStudAttr = $peStud->attributes();
				
				// assemble full name
				$fullname = $peStudAttr['firstname'];
				if(!empty($wlStudAttr['middlename'])){
					$fullname = $fullname . " " . $peStudAttr['middlename'];
				}
				$fullname = $fullname . " " . $peStudAttr['lastname'];
				
				printf('<a href=%s>%s</a></br>', base_url('admissions/registerStudent/' . $peStudAttr['formid']), $fullname);
			endforeach;
			?>
	    </fieldset>
		<fieldset>
			<legend>
                Currently Waitlisted Students:
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
				
				printf('<label>%s</label></br>', $fullname);
			endforeach;
			?>
	    </fieldset>
    </form>
</div>