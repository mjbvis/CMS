<!DOCTYPE html>

<html>
<head>

<script src="http://code.jquery.com/jquery-1.7.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>js/jquery.bbq.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.timepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/carbo.grid.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/carbo.form.js" type="text/javascript"></script>

</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/carbo/jquery-ui-1.8.16.custom.css" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>css/carbo.grid.css" rel="stylesheet" type="text/css" media="all" />
    <!--[if lt IE 7]><link href="<?php echo base_url(); ?>css/carbo.grid.ie6.css" rel="stylesheet" type="text/css" media="all" /><![endif]-->
    <link href="<?php echo base_url(); ?>css/carbo.form.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>css/960.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="formBox">
	<form id='studentMedical' method="post" action="saveStudentMedical" accept-charset='UTF-8' class="clearfix">	
        <fieldset>
            <legend>
                Medical Information
            </legend>
            <ul>
                <li>
                    <label>PreferredHospital:</label>
					<input type='text' name='preferredHospitalName' id='preferredHospitalId' placeholder="Preferred Hospital" max='50' 
						value="<?php echo set_value('preferredhospital', $studentMedicalInformation->preferredhospital);  ?>" />
                    </br>
                </li>
                <li>
                	<label>Hospital's Phone:</label>
                	<input type="text" name="hospitalPhoneName" id="hospitalPhoneId" placeholder="555-555-5555" max="15" 
                		value="<?php echo set_value('hospitalphone', $studentMedicalInformation->hospitalphone);  ?>" />
                	</br>
                </li>
				<li>
					<label>Physician's Name:</label>
					<input type="text" name="physicianName" id="physicianId" placeholder="Name of your physician" max="50" 
						value="<?php echo set_value('physician', $studentMedicalInformation->physician);  ?>"/>
					</br>
				</li>
				<li>
					<label>Physician's Phone:</label>
					<input type="text" name="pPhoneName" id="pPhoneId" placeholder="555-555-5555" max="15" 
						value="<?php echo set_value('physicianphone', $studentMedicalInformation->physicianphone);  ?>"/>
					</br>
				</li>
				<li>
					<label>Dentist's Name:</label>
					<input type="text" name="dentistName" id="dentistId" placeholder="Name of your dentist" max="50" 
						value="<?php echo set_value('dentist', $studentMedicalInformation->dentist);  ?>"/>
					</br>
				</li>
								<li>
					<label>Dentist's Phone:</label>
					<input type="text" name="dPhoneName" id="dPhoneId" placeholder="555-555-5555" max="15" 
						value="<?php echo set_value('dentistphone', $studentMedicalInformation->dentistphone);  ?>"/>
					</br>
				</li>
				<li>
					 <label>Medical Conditions:</label>
					<textarea name="medicalConditionsName" id="medicalConditionsId" cols="100" rows="2" max="1000" 
						placeholder="List any medican conditions here..."><?php echo set_value('medicalconditions', $studentMedicalInformation->medicalconditions);  ?></textarea></br>
				</li>
				<li>
				 <label>Allergies:</label>
					<textarea name="allergiesName" id="allergiesId" cols="100" rows="2" max="1000" 
						placeholder="List any allergies here..."><?php echo set_value('allergies', $studentMedicalInformation->allergies);  ?></textarea></br>
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
						<input type='text' name='insuranceCompanyName' id='insuranceCompanyId' placeholder="Insurance Companies Name" 
							value="<?php echo set_value('insurancecompany', $studentInsurance->insurancecompany);  ?>" max='50' />
	                    </br>
	                </li>
					<li>
	                    <label>Certificate Number:</label>
						<input type='text' name='certificateNumberName' id='certificateNumberId' placeholder="Certificate Number"
							value="<?php echo set_value('certificatenumber', $studentInsurance->certificatenumber);  ?>" max='50' />
	                    </br>
	                </li>
	                <li>
						<label>Name of Insured:</label>
						<input type="text" name="insuredName" id="insuredId" placeholder="Name of Insured" max="50" 
							value="<?php echo set_value('nameofinsured', $studentInsurance->nameofinsured);  ?>"/>
						</br>
					</li>
					<li>
						<label>Employer:</label>
						<input type="text" name="employerName" id="employerId" placeholder="Employers Name" max="50" 
							value="<?php echo set_value('employer', $studentInsurance->employer);  ?>"/>
					</li>
				</ul>
			</fieldset>
		<input type="submit" value="Save and Continue" class="submit"/>
	</form>
	</div>
</body>

</html>