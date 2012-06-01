<div class="formBox">
	
	<?php
	/* display validation errors */
	$errors = validation_errors();
	if (!empty($errors)) {
		printf('<div class="validationBox">%s</div>', $errors);
	}
	?>
	
	<form id='studentMedical' method="post" accept-charset='UTF-8' class="clearfix">
		<fieldset>
			<legend>Child's Information</legend>
			<ul>
				<li>
					<label>Name:</label>
					<input type="text" name="cFirstName" id="cFirstId" max="45" placeholder="First Name" value="<?php echo ($firstName); ?>" readonly="readonly" />
					<input type="text" name="cMiddleName" id="cMiddleId" max="45" value="<?php echo $middleName; ?>" readonly="readonly" />
					<input type="text" name="cLastName" id="cLastId" max="45" placeholder="Last Name" value="<?php echo ($lastName); ?>" readonly="readonly" /> </br>
				</li>
			</ul>
		</fieldset>	
        <fieldset>
            <legend>
                Medical Information
            </legend>
            <ul>
                <li>
                    <label>Preferred Hospital:</label>
					<input type='text' name='preferredHospitalName' id='preferredHospitalId' placeholder="Hospital" max='50' 
						value="<?php echo set_value('preferredHospitalName');  ?>" />
                    </br>
                </li>
                <li>
                	<label>Hospital's Phone:</label>
                	<input type="text" name="hospitalPhoneName" id="hospitalPhoneId" placeholder="555-555-5555" max="15" 
                		value="<?php echo set_value('hospitalPhoneName');  ?>" />
                	</br>
                </li>
				<li>
					<label>Physician's Name:</label>
					<input type="text" name="physicianName" id="physicianId" placeholder="Name" max="50" 
						value="<?php echo set_value('physicianName');  ?>"/>
					</br>
				</li>
				<li>
					<label>Physician's Phone:</label>
					<input type="text" name="pPhoneName" id="pPhoneId" placeholder="555-555-5555" max="15" 
						value="<?php echo set_value('pPhoneName');  ?>"/>
					</br>
				</li>
				<li>
					<label>Dentist's Name:</label>
					<input type="text" name="dentistName" id="dentistId" placeholder="Name" max="50" 
						value="<?php echo set_value('dentistName');  ?>"/>
					</br>
				</li>
				<li>
					<label>Dentist's Phone:</label>
					<input type="text" name="dPhoneName" id="dPhoneId" placeholder="555-555-5555" max="15" 
						value="<?php echo set_value('dPhoneName');  ?>"/>
					</br>
				</li>
				<li>
					 <label>Medical Conditions:</label>
					<textarea name="medicalConditionsName" id="medicalConditionsId" cols="100" rows="2" max="1000" 
						placeholder="List any medican conditions here..."><?php echo set_value('medicalConditionsName');  ?></textarea></br>
				</li>
				<li>
				 <label>Allergies:</label>
					<textarea name="allergiesName" id="allergiesId" cols="100" rows="2" max="1000" 
						placeholder="List any allergies here..."><?php echo set_value('allergiesName');  ?></textarea></br>
				</li>
			</ul>
			</fieldset>
			<fieldset>
				<legend>
                Insurance Information
            	</legend>
				<ul>
					<li>
	                    <label>Insurance Company:</label>
						<input type='text' name='insuranceCompanyName' id='insuranceCompanyId' placeholder="Name" 
							value="<?php echo set_value('insuranceCompanyName');  ?>" max='50' />
	                    </br>
	                </li>
					<li>
	                    <label>Certificate Number:</label>
						<input type='text' name='certificateNumberName' id='certificateNumberId' placeholder="Certificate Number"
							value="<?php echo set_value('certificateNumberName');  ?>" max='50' />
	                    </br>
	                </li>
					<li>
						<label>Employer:</label>
						<input type="text" name="employerName" id="employerId" placeholder="Employers Name" max="50" 
							value="<?php echo set_value('employerName');  ?>"/>
					</li>
				</ul>
			</fieldset>
		<input type="submit" value="Save and Continue" name="studentMedical" class="submit"/>
	</form>
</div>
