
<div class="formBox">
	<form id="studentMedicalSelector">
		<fieldset>
			<legend>
                Students with Pending Medical Forms:
            </legend>
			
	    	<?php
	    	foreach($Students as $stud):
				$studAttr = $stud->attributes();
				
				// assemble full name
				$fullname = $studAttr['firstname'];
				if(!empty($studAttr['middlename'])){
					$fullname = $fullname . " " . $studAttr['middlename'];
				}
				$fullname = $fullname . " " . $studAttr['lastname'];
				
				printf('<a href=%s>%s</a></br>', base_url('admissions/studentMedical/' . $studAttr['studentid']), $fullname);
			endforeach;
			?>
	    </fieldset>
    </form>
</div>