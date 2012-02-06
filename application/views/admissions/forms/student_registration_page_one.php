<php??>
<script type="text/javascript" >
function showhide(value) {
	if(value == 'adInRadio') {
		document.getElementById('adInTextDiv').style.display = "block";
		document.getElementById('adInLabel').style.display = "block";
		document.getElementById('otherTextDiv').style.display = "none";
		document.getElementById('otherLabel').style.display = "none";
	}
	else if(value == 'otherRadio')
	{
		document.getElementById('adInTextDiv').style.display = "none";
		document.getElementById('adInLabel').style.display = "none";
		document.getElementById('otherTextDiv').style.display = "block";
		document.getElementById('otherLabel').style.display = "block";
	}
	else if (value == 'other') {
		document.getElementById('adInTextDiv').style.display = "none";
		document.getElementById('adInLabel').style.display = "none";
		document.getElementById('otherTextDiv').style.display = "none";
		document.getElementById('otherLabel').style.display = "none";
	}
}
</script>
<form id='studRegPgOne' action='studentRegistration.php' method='post' accept-charset='UTF-8'>
	<fieldset>
		<legend>Contact Information</legend>
		<label for='parentsNames'>Parent's Names:</label>
		<input type='text' name='parentsNames' id='parentsNamesId' max='50' /> </br>
		<label for='childrenNamesAges' >Children's name(s)/ages: </label>
		<input type='text' name='childrenNamesAges' id='childrenNamesAgeId' max='100' /> </br>
		<label for='dob' >DOB: </label>
		<input type='text' name='dob' id='dob' max='10' size='50%'/></br>
		<label for='contactDate' >Date first contacted: </label>
		<input type='text' name='contactDate' id='contactDateId' max='10' /> </br>
		<label for='phoneNumber' >Phone Number: </label>
		<input type='text' name='phoneNumber' id='phoneNumberId' max='13' /> </br>
		<label for='visitDate' >Visit Date: </label>
		<input type='text' name='visitDate' id='visitDateId' max='13' /> </br>
		<label for='email' >Email: </label>
		<input type='text' name='email' id='emailId' max='13' /> </br>
		<label for='learnedAboutCMS' >How did you hear about CMS?  </label></br>
		<div class="learnedAboutAnswers">
			<input type='radio' name='learnedAbout' id='webSearchId' onClick="showhide('other')"/> Web Search
			<input type='radio' name='learnedAbout' id='cmsFamilyId' onClick="showhide('other')"/> CMS Family
			<input type='radio' name='learnedAbout' id='friendsId' onClick="showhide('other')"/> Friends 
			<input type='radio' name='learnedAbout' id='adInRadioId' onClick="showhide('adInRadio')"/> Ad In
			<input type='radio' name='learnedAbout' id='otherRadioId' onClick="showhide('otherRadio')"/> Other
			<div id="adInTextDiv" style="display:none">
				<label for="adIn" id="adInLabelId" style="display:none">Ad In:</label>
				<input type='text' name='learnedAbout' id='adInTextId' />
			</div>
			<div id="otherTextDiv" style="display:none" >
				<label for="other" id="otherLabelId" style="display:none">Other:</label>
				<input type='text' name='learnedAbout' id='otherTextId'/>
			</div>
		</div>
	</fieldset>
	
	<fieldset
		<label for='interest'>Level of Interest</label>
		<input type="radio" name="interest" id="interestLowId" /> Low
		<input type="radio" name="interest" id="interestMediumId" /> Medium
		<input type="radio" name="interest" id="interestHighId" /> High </br>
		<label for='understanding'>Understanding of Montessori</label>
		<input type="radio" name="understanding" id="understandingLowId" /> Little
		<input type="radio" name="understanding" id="understandingMediumId" /> Average
		<input type="radio" name="understanding" id="understandingHighId" /> High </br>
		<label for='willingness'>Willingness to learn more</label>
		<input type="radio" name="willingness" id="willingnessLowId" /> Low
		<input type="radio" name="willingness" id="willingnessMediumId" /> Medium
		<input type="radio" name="willingness" id="willingnessHighId" /> High </br>
		If Moving: City/St:	
			<input type="text" name="movingCitySt" id="movingCityStId" max="100" /> </br>
		School:	
			<input type="text" name="movingSchool" id="movingSchoolId" max="100" /> </br>
		Notes: 
			<input type="checkbox" name="learningNotes" id="inDepthId" /> In Depth Learning
			<input type="checkbox" name="learningNotes" id="ownPaceId" /> At Own Pace
			<input type="checkbox" name="learningNotes" id="handsOnId" /> Hands On
			<input type="checkbox" name="learningNotes" id="mixedAgesId" /> Mixed Ages </br>
		Montessori impressions: </br>
			<textarea name="impressions" id="montessoriImpressionsId" cols="100" rows="2" max="1000" 
				onclick="this.focus();this.select()">Montessori Impressions...</textarea></br>
		Interviews impressions: </br>
			<textarea name="impressions" id="interviewsImpressionsId" cols="100" rows="4" max="3000"
				onclick="this.focus();this.select()">Interviewer Impressions...</textarea></br>	
	</fieldset>
	
	<fieldset>
		Classroom Observation: </br>
		Date:
			<input type="text" name="observationDateText" id="observationDateId" max="13" /> </br>
		Class:
			<input type="text" name="classroomText" id="classId" max="30" /> </br>
		Attended:
			<input type="radio" name="attendedRadio" id="attendedRadioId" /> Yes
			<input type="radio" name="attendedRadio" id="attendedRadioId" /> No </br>
		On Time:
			<input type="radio" name="onTimeRadio" id="onTimeRadioId" /> Yes
			<input type="radio" name="onTimeRadio" id="onTimeRadioId" /> No </br>
		Interview Date: 
			<input type="text" name="interviewDateText" id="interviewDateId" max="13" /> </br>
	</fieldset>
	
	<fieldset>
		Date Application Received:
			<input type="text" name="appReceivedText" id="appReceivedId" max="13" /> </br>
		Date Application Fee Received:
			<input type="text" name="feeReceivedText" id="feeReceivedId" max="13" /> </br>
	</fieldset>
	
</form>


