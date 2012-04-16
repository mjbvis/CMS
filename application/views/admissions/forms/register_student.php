<script type="text/javascript">
function show_hide_page_six(value) {
	if(value == 'yes') {
		document.getElementById('petsTypeDivId').style.display = "block";
		document.getElementById('yesPetsTypeLabelId').style.display = "block";
		document.getElementById('yesPetsNameLabelId').style.display = "block";
	}
	if(value == 'no') {
		document.getElementById('petsTypeDivId').style.display = "none";
		document.getElementById('yesPetsTypeLabelId').style.display = "none";
		document.getElementById('yesPetsNameLabelId').style.display = "none";
	}	
	if(value == 'parent') {
		document.getElementById('parentDiv').style.display="block";
		document.getElementById('parentLabelId').style.display="block";
		document.getElementById('parentTextId').style.display="block";
		document.getElementById('friendDiv').style.disp="none";
		document.getElementById('friendLabelId').style.disp="none";
		document.getElementById('friendTextId').style.disp="none";
		document.getElementById('newspaperDiv').style.disp="none";
		document.getElementById('newspaperLabelId').style.disp="none";
		document.getElementById('newspaperTextId').style.disp="none";
		document.getElementById('otherDiv').style.disp="none";
		document.getElementById('otherLabelId').style.disp="none";
		document.getElementById('otherTextId').style.disp="none";	
	}
	if(value == 'friend') {
		document.getElementById('parentDiv').style.display="none";
		document.getElementById('parentLabelId').style.display="none";
		document.getElementById('parentTextId').style.display="none";
		document.getElementById('friendDiv').style.display="block";
		document.getElementById('friendLabelId').style.display="block";
		document.getElementById('friendTextId').style.display="block";
		document.getElementById('newspaperDiv').style.display="none";
		document.getElementById('newspaperLabelId').style.display="none";
		document.getElementById('newspaperTextId').style.display="none";
		document.getElementById('otherDiv').style.display="none";
		document.getElementById('otherLabelId').style.display="none";
		document.getElementById('otherTextId').style.display="none";	
	}
	if(value == 'newspaper') {
		document.getElementById('parentDiv').style.display="none";
		document.getElementById('parentLabelId').style.display="none";
		document.getElementById('parentTextId').style.display="none";
		document.getElementById('friendDiv').style.display="none";
		document.getElementById('friendLabelId').style.display="none";
		document.getElementById('friendTextId').style.display="none";
		document.getElementById('newspaperDiv').style.display="block";
		document.getElementById('newspaperLabelId').style.display="block";
		document.getElementById('newspaperTextId').style.display="block";
		document.getElementById('otherDiv').style.display="none";
		document.getElementById('otherLabelId').style.display="none";
		document.getElementById('otherTextId').style.display="none";
	}
	if(value == 'extra') {
		document.getElementById('parentDiv').style.display="none";
		document.getElementById('parentLabelId').style.display="none";
		document.getElementById('parentTextId').style.display="none";
		document.getElementById('friendDiv').style.display="none";
		document.getElementById('friendLabelId').style.display="none";
		document.getElementById('friendTextId').style.display="none";
		document.getElementById('newspaperDiv').style.display="none";
		document.getElementById('newspaperLabelId').style.display="none";
		document.getElementById('newspaperTextId').style.display="none";
		document.getElementById('otherDiv').style.display="block";
		document.getElementById('otherLabelId').style.display="block";
		document.getElementById('otherTextId').style.display="block";
	}
		if(value == 'other') {
		document.getElementById('parentDiv').style.display="none";
		document.getElementById('parentLabelId').style.display="none";
		document.getElementById('parentTextId').style.display="none";
		document.getElementById('friendDiv').style.display="none";
		document.getElementById('friendLabelId').style.display="none";
		document.getElementById('friendTextId').style.display="none";
		document.getElementById('newspaperDiv').style.display="none";
		document.getElementById('newspaperLabelId').style.display="none";
		document.getElementById('newspaperTextId').style.display="none";
		document.getElementById('otherDiv').style.display="none";
		document.getElementById('otherLabelId').style.display="none";
		document.getElementById('otherTextId').style.display="none";
	}
}
</script>

<form id='register_student' method='post' accept-charset='UTF-8' class='clearfix'>
	<fieldset>
		<legend>Child's Information</legend>
		<ul>
			<li>
				<label>Name:</label>
				<input type="text" name="cFirstName" id="cFirstId" max="45" placeholder="First Name" value="<?php echo ($firstName); ?>" readonly="readonly" />
				<input type="text" name="cMiddleName" id="cMiddleId" max="45" value="<?php echo $middleName; ?>" readonly="readonly" />
				<input type="text" name="cLastName" id="cLastId" max="45" placeholder="Last Name" value="<?php echo ($lastName); ?>" readonly="readonly" />
			</li>
			<li>
				<label>Address:</label>
				<input type="text" name="cAddressName" id="cAddressId" max="100" placeholder="Address" /> </br>
			</li>
			<li>
				<label>Phone Number:</label>
				<input type="text" name="cPhoneName" id="cPhoneId" max="15" placeholder="555-555-5555"/> </br>
			</li>
			<li>
				<label>Place of Birth:</label>
				<input type="text" name="cityBirthplaceName" id="cityBirthplaceId" max="50" placeholder="City" />
				<input type="text" name="stateBirthplaceName" id="stateBirthplaceId" max="50" placeholder="State" /> </br>
			</li>
			<li>
				<label>Date of Birth:</label>
				<input type="text" name="dobName" id="dobId" max="15" placeholder="01/01/2001" /> </br>
			</li>
		</ul>
	</fieldset>
	<fieldset>
		<legend>Parent/Guardian#1 Information</legend>
		<ul>
			<li>
				<label>Parent/Guardian First/Last Name:</label>
				<input type="text" name="pOneFirstName" id="pOneFirstId" max="50" placeholder="First Name" />
				<input type="text" name="pOneLastName" id="pOneLastId" max="50" placeholder="Last Name" /> </br>
			</li>
			<li>
				<label>Address:</label>
				<input type="text" name="pOneAddressName" id="pOneAddressId" max="100" placeholder="Address" /> </br>
			</li>
			<li>
				<label>Email Address:</label>
				<input type="text" name="pOneEmailName" id="pOneEmailId" max="100" placeholder="Email@address.com"  /> </br>
			</li>
			<li>
				<label>Home Phone:</label>
				<input type="text" name="pOneHomePhoneName" id="pOneHomePhoneId" max="15" placeholder="555-555-5555" /> </br>
			</li>
			<li>
				<label>Cell Phone:</label>
				<input type="text" name="pOneCellPhoneName" id="pOneCellPhoneId" max="15" placeholder="555-555-5555"  /> </br>
			</li>
			<li>
				<label>Business Phone:</label>
				<input type="text" name="pOneBusinessPhoneName" id="pOneBusinessPhoneId" max="15" placeholder="555-555-5555"  /> </br>
			</li>
			<li>
				<label>Employer:</label>
				<input type="text" name="pOneEmployerName" id="pOneEmployerId" max="100" placeholder="Employer Name"  /> </br>
			</li>
			<li>
				<label>Occupation:</label>
				<input type="text" name="pOneOccupationName" id="pOneOccupationId" max="100" placeholder="Occupation"  /> </br>
			</li>
		</ul>
	</fieldset>
	<fieldset>
		<legend>Parent/Guardian#2 Information</legend>
		<ul>
			<li>
				<label>Parent/Guardian First/Last Name:</label>
				<input type="text" name="pOneFirstName" id="pOneFirstId" max="50" placeholder="First Name" />
				<input type="text" name="pOneLastName" id="pOneLastId" max="50" placeholder="Last Name" /> </br>
			</li>
			<li>
				<label>Address:</label>
				<input type="text" name="pOneAddressName" id="pOneAddressId" max="100" placeholder="Address" /> </br>
			</li>
			<li>
				<label>Email Address:</label>
				<input type="text" name="pOneEmailName" id="pOneEmailId" max="100" placeholder="Email@address.com"  /> </br>
			</li>
			<li>
				<label>Home Phone:</label>
				<input type="text" name="pOneHomePhoneName" id="pOneHomePhoneId" max="15" placeholder="555-555-5555" /> </br>
			</li>
			<li>
				<label>Cell Phone:</label>
				<input type="text" name="pOneCellPhoneName" id="pOneCellPhoneId" max="15" placeholder="555-555-5555"  /> </br>
			</li>
			<li>
				<label>Business Phone:</label>
				<input type="text" name="pOneBusinessPhoneName" id="pOneBusinessPhoneId" max="15" placeholder="555-555-5555"  /> </br>
			</li>
			<li>
				<label>Employer:</label>
				<input type="text" name="pOneEmployerName" id="pOneEmployerId" max="100" placeholder="Employer Name"  /> </br>
			</li>
			<li>
				<label>Occupation:</label>
				<input type="text" name="pOneOccupationName" id="pOneOccupationId" max="100" placeholder="Occupation"  /> </br>
			</li>
		</ul>
	</fieldset>
	
	<fieldset>
		<legend>Admission Information (new students only)</legend>
		<ul>
			<li>
				<label>Does your child have previous school or day care experience? Please list name and address:</label>
				<textarea name="daycareExperienceName" id="daycareExperienceId" placeholder="Enter answer here..." max="250"></textarea></br>
			</li>
			<li>
				<label>What social experience does your child have? (play groups, swimming, gym):</label>
				<textarea name="socialExperienceName" id="socialExperienceId" placeholder="Enter answer here..." max="250"></textarea></br>
			</li>
			<li>
				<label>Ways you comfort your child when upset:</label>
				<input type="text" name="comfortChildName" id="comfortChildId" placeholder="Enter answer here..." max="250"/></br>
			</li>
			<li>
				<label>Is your child able to care for his/her toileting needs?</label>
				<input type="text" name="toiletNeedsName" id="toiletNeedsId" placeholder="Enter answer here..." max="250"/></br>
			</li>
			<li>
				<label>Is yoru child in habit of taking a nap? When?</label>
				<input type="text" name="napTakingName" id="napTakingId" placeholder="Enter answer here..." max="250"/></br>
			</li>
			<li>
				<label>Does your child play outside on a regular basis?</label>
				<input type="text" name="playOutsideName" id="playOutsideId" placeholder="Enter answer here..." max="250"/></br>
			</li>
			<li>
				<label>Do you have any household pets?</label>
				<div class="petsDiv">
					<input type="radio" name="hasPetsName" id="yesPetsId" onClick="showhide('yes')"/> Yes
					<input type="radio" name="hasPetsName" id="noPetsId" onClick="showhide('no')"/> No
					<div id="petsTypeDivId" style="display:none">
						<label for="yesPetsTypeLabel" id="yesPetsTypeLabelId" style="display:none">Type:
						<input type='text' name='typeOfPetName' id='typeOfPetId' placeholder="Enter answer here..." max="50"/>
						<label for="yesPetsNameLabel" id="yesPetsNameLabelId" style="display:none">Name:
						<input type='text' name='nameOfPetName' id='nameOfPetId' placeholder="Enter answer here..." max="50"/>
					</div>
				</div>
			</li>
			<li>
				<label>Please list some of your child's interests:</label>
				<textarea name="childInterestsName" id="childInterestsId" cols="100" rows="2" max="250"
					placeholder="Enter answer here..."></textarea></br>		
			</li>
			<li>
				<label>Siblings:</label>
				<input type="text" name="siblingOneFirstName" id="siblingOneFirstId" placeholder="Siblings First name..." max="250"/>
				<input type="text" name="siblingsOneLastName" id="siblingOneLastId" placeholder="Siblings Last name..." max="250"/>
				<input type="text" name="siblingOneAgeName" id="silblingOneAgeId" placeholder="Siblings Age..." max="250"/></br>
				<input type="text" name="siblingTwoFirstName" id="siblingTwoFirstId" placeholder="Siblings First name..." max="250"/>
				<input type="text" name="siblingsTwoLastName" id="siblingTwoLastId" placeholder="Siblings Last name..." max="250"/>
				<input type="text" name="siblingTwoAgeName" id="silblingTwoAgeId" placeholder="Siblings Age..." max="250"/></br>
			</li>
			<li>
				<label>Is there anythign else that you feel is important for the school to be aware of?</label>
				<textarea name="otherImportantName" id="otherImportantId" cols="100" rows="2" max="500"
					placeholder="Enter answer here..."></textarea></br>
			</li>
		</ul>
	</fieldset>
	<fieldset>
		How did you hear about Corvallis Montessori School?</br>
		<div class="hearAbout">
			<input type='radio' name='hearAboutName' id='parentId' onClick="show_hide_page_six('parent')"/> Parent of a CMS student
			<input type='radio' name='hearAboutName' id='friendId' onClick="show_hide_page_six('friend')"/> a Friend
			<input type='radio' name='hearAboutName' id='newspaperId' onClick="show_hide_page_six('newspaper')"/> Newspaper 
			<input type='radio' name='hearAboutName' id='internetId' onClick="show_hide_page_six('other')"/> Internet
			<input type='radio' name='hearAboutName' id='posterId' onClick="show_hide_page_six('other')"/> Poster
			<input type='radio' name='hearAboutName' id='otherId' onClick="show_hide_page_six('extra')"/> Other
			<div id="parentDiv" style="display:none">
				<label for="parent" id="parentLabelId" style="display:none">Parent:
				<input type='text' name='learnedAboutName' id='parentTextId' placeholder="Specify name..." max="250"/>
			</div>
			<div id="friendDiv" style="display:none">
				<label for="parent" id="friendLabelId" style="display:none">Friend:
				<input type='text' name='learnedAboutName' id='friendTextId' placeholder="Specify name..." max="250/>
			</div>
			<div id="newspaperDiv" style="display:none">
				<label for="parent" id="newspaperLabelId" style="display:none">Newspaper:
				<input type='text' name='learnedAboutName' id='newspaperTextId' placeholder="Specify name..." max="250/>
			</div>
			<div id="otherDiv" style="display:none">
				<label for="parent" id="otherLabelId" style="display:none">Other:
				<input type='text' name='learnedAboutName' id='otherTextId' placeholder="Specify..." max="250/>
			</div>
		</div>		
	</fieldset>
</form>