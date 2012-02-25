x<script type="text/javascript">
function show_hide_page_seven(value) {
	if(value == 'yes') {
		document.getElementById('insuranceDivId').style.display = "block";
		document.getElementById('insuranceCompanyLabelId').style.display = "block";
		document.getElementById('groupNumberLabelId').style.display = "block";
		document.getElementById('nameOfInsuredLabelId').style.display = "block";
		document.getElementById('employerLabelId').style.display = "block";
	}
	if(value == 'no') {
		document.getElementById('insuranceDivId').style.display = "none";
		document.getElementById('insuranceCompanyLabelId').style.display = "none";
		document.getElementById('groupNumberLabelId').style.display = "none";
		document.getElementById('nameOfInsuredLabelId').style.display = "none";
		document.getElementById('employerLabelId').style.display = "none";
	}
}
</script>
<form id='studRegPgFive' action='studentRegistrationPageFive.php' method='post' accept-charset='UTF-8'>
	<fieldset>
		<legend>Emergency Information and Medical Release</legend>
		Child's First/Last Name:
			<input type="text" name="cFirstName" id="cFirstNameId" max="50" placeholder="First Name..."/>
			<input type="text" name="cLastName" id="cLastNameId" max="50" placeholder="Last Name..."/>
		Date of Birth:
			<input type="text" name="dobName" id="dobId" max="50" placeholder="Date of Birth..."/></br>
		1) I/we authorize the two persons listed below to assume care of my child in teh unlikely event that I cannot be reached. 
		If my child becomes ill at school, I understand that every effort will be made to contact me before releasing my child to
		these to these emergency contacts (please list two other than parents):</br>
		Authorized Person #1:
		<input type="text" name="contactOneFirstName" id="contactOneFirstId" max="50" placeholder="First Name..."/>
		<input type="text" name="contactOneLastName" id="contactOneLastId" max="50" placeholder="Last Name..."/>
		Phone:
		<input type="text" name="contactOnePhoneName" id="contactOnePhoneId" max="13" placeholder="555-555-5555"/> </br>
		Address:
		<input type="text" name="contactOneAddressName" id="contactOneAddressId" max="13" placeholder="Current Address..."/> </br>
		Authorized Person #2:
		<input type="text" name="contactTwoFirstName" id="contactTwoFirstId" max="50" placeholder="First Name..."/>
		<input type="text" name="contactTwoLastName" id="contactTwoLastId" max="50" placeholder="Last Name..."/>
		Phone:
		<input type="text" name="contactTwoPhoneName" id="contactTwoPhoneId" max="13" placeholder="555-555-5555"/> </br>
		Address:
		<input type="text" name="contactTwoAddressName" id="contactTwoAddressId" max="13" placeholder="Current Address..."/> </br>
		
		2) In the event of a medical emergency, I/we authorize the Corvallis Montessori School to have my child
		transported to the closest hospital and receive any treatment deemed necessary by the attending physician
		while efforts are made to reach me. </br>
		Preferred Hospital:
		<input type="text" name="hospitalName" id="hospitalId" max="50" placeholder="Hospital Name..."/>
		<input type="text" name="hospitalPhoneName" id="hospitalPhoneId" max="50" placeholder="Hospital Phone..."/></br>
	</fieldset>
	<fieldset>
		<legend>Medical Information</legend>
		Child's Physician:
		<input type="text" name="physicianName" id="physicianId" max="50" placeholder="Physician's name..."/>
		<input type="text" name="physicianPhoneName" id="physicianPhoneId" max="14" placeholder="Physician's phone..."/></br>
		Known medical problems/conditions/illnesses: </br> 
		<textarea name="medicalProblemsName" id="medicalProblemsId" cols="100" rows="2" max="1000"
					placeholder="Enter answer here..."></textarea></br>
		Allergies: </br>
		<textarea name="medicalAllergiesName" id="medicalAllergiesId" cols="100" rows="2" max="1000"
				placeholder="Enter answer here..."></textarea></br>
		Child is covered by private medical insurance program?
		<div class="insuranceDiv">
			<input type="radio" name="insuranceName" id="yesInsuranceId" onClick="show_hide_page_seven('yes')"/> Yes
			<input type="radio" name="insuranceName" id="noInsuranceId" onClick="show_hide_page_seven('no')"/> No
			<div id="insuranceDivId" style="display:none">
				<label for="insuranceCompany" id="insuranceCompanyLabelId" style="display:none">Insurance Company:
				<input type='text' name='insuranceCompanyName' id='insuranceCompanyId' placeholder="Enter answer here..."/>
				<label for="groupNumber" id="groupNumberLabelId" style="display:none">Certificate Number/Group Number:
				<input type='text' name='groupNumberName' id='groupNumberId' placeholder="Enter answer here..."/>
				<label for="nameOfInsured" id="nameOfInsuredLabelId" placeholder="Enter answer here..."> Name of Insured:
				<input type="text" name="nameOfInsuredName" id="nameOfInsuredId" placeholder="Enter answer here..."/>
				<label for="employer" id="employerLabelId" style="display:none">Employer:
				<input type="text" name="employerName" id="employerId" placeholder="Enter your answer here..."/>
			</div>
		</div>
		</br>
		I understand that I will be fully responsible for all expenses resulting from the emergency treatment and/or transportation of my child.
		
		*Please use phone number(s) where you can be reached in the event of an emergency.
	</fieldset>
</form>