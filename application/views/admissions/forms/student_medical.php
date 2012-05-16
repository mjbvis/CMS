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
					<input type='text' name='preferredHospitalName' id='preferredHospitalId' placeholder="Preferred Hospital" max='50' />
                    </br>
                </li>
                <li>
                	<label>Hospital's Phone:</label>
                	<input type="text" name="hospitalPhoneName" id="hospitalPhoneId" placeholder="555-555-5555" max="15" />
                	</br>
                </li>
				<li>
					<label>Physician's Name:</label>
					<input type="text" name="pfirstName" id="pfirstId" placeholder="First Name" max="50" />
					<input type="text" name="plastName" id="plastId" placeholder="Last Name" max="50" />
					</br>
				</li>
				<li>
					<label>Physician's Phone:</label>
					<input type="text" name="pPhoneName" id="pPhoneId" placeholder="555-555-5555" max="15" />
					</br>
				</li>
				<li>
					<label>Dentist's Name:</label>
					<input type="text" name="dfirstName" id="dfirstId" placeholder="First Name" max="50" />
					<input type="text" name="dlastName" id="dlastId" placeholder="Last Name" max="50" />
					</br>
				</li>
								<li>
					<label>Dentist's Phone:</label>
					<input type="text" name="dPhoneName" id="dPhoneId" placeholder="555-555-5555" max="15" />
					</br>
				</li>
				<li>
					 <label>Medical Conditions:</label>
					<textarea name="medicalConditionsName" id="medicalConditionsId" cols="100" rows="2" max="1000" 
						placeholder="List any medican conditions here..."></textarea></br>
				</li>
				<li>
				 <label>Allergies:</label>
					<textarea name="allergiesName" id="allergiesId" cols="100" rows="2" max="1000" 
						placeholder="List any allergies here..."></textarea></br>
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
						<input type='text' name='insuranceCompanyName' id='insuranceCompanyId' placeholder="Insurance Companies Name" max='50' />
	                    </br>
	                </li>
					<li>
	                    <label>Certificate Number:</label>
						<input type='text' name='certificateNumberName' id='certificateNumberId' placeholder="Certificate Number" max='50' />
	                    </br>
	                </li>
	                <li>
						<label>Name of Insured:</label>
						<input type="text" name="ifirstName" id="ifirstId" placeholder="First Name" max="50" />
						<input type="text" name="ilastName" id="ilastId" placeholder="Last Name" max="50" />
						</br>
					</li>
					<li>
						<label>Employer:</label>
						<input type="text" name="employerName" id="employerId" placeholder="Employers Name" max="50" />
					</li>
				</ul>
			</fieldset>
		<input type="submit" value="Save and Continue" class="submit"/>
	</form>
	</div>
</body>

</html>