<script type="text/javascript">
function show_hide(value) {
	switch(value){
		case 'yes':
			document.getElementById('hasPetsDiv').style.display = "block";
			break;
		case'no':
			document.getElementById('hasPetsDiv').style.display = "none";
			break;
		case 'parent':
			document.getElementById('parentTextId').style.display="block";
			document.getElementById('friendTextId').style.display="none";
			document.getElementById('newspaperTextId').style.display="none";
			document.getElementById('otherTextId').style.display="none";	
			break;
		case 'friend':
			document.getElementById('parentTextId').style.display="none";
			document.getElementById('friendTextId').style.display="block";
			document.getElementById('newspaperTextId').style.display="none";
			document.getElementById('otherTextId').style.display="none";
			break;	
		case 'newspaper':
			document.getElementById('parentTextId').style.display="none";
			document.getElementById('friendTextId').style.display="none";
			document.getElementById('newspaperTextId').style.display="block";
			document.getElementById('otherTextId').style.display="none";
			break;
		case 'extra':
			document.getElementById('parentTextId').style.display="none";
			document.getElementById('friendTextId').style.display="none";
			document.getElementById('newspaperTextId').style.display="none";
			document.getElementById('otherTextId').style.display="block";
			break;
		case 'other':
			document.getElementById('parentTextId').style.display="none";
			document.getElementById('friendTextId').style.display="none";
			document.getElementById('newspaperTextId').style.display="none";
			document.getElementById('otherTextId').style.display="none";
			break;
		default:
			break;
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
		<legend>Admission Information (new students only)</legend>
		<ul>
			<li>
				Does your child have previous school or day care experience?</br>
				Please list name and address:</br>
				<textarea name="daycareExperienceName" id="daycareExperienceId" placeholder="Enter answer here..." max="250"></textarea></br>
			</li>
			<li>
				What social experience does your child have (play groups, swimming, gym)?</br>
				<textarea name="socialExperienceName" id="socialExperienceId" placeholder="Enter answer here..." max="250"></textarea></br>
			</li>
			<li>
				In what ways do you comfort your child when upset?</br>
				<textarea type="text" name="comfortChildName" id="comfortChildId" placeholder="Enter answer here..." max="250"></textarea></br>
			</li>
			<li>
				Is your child able to care for his/her toileting needs? How?</br>
				<textarea type="text" name="toiletNeedsName" id="toiletNeedsId" placeholder="Enter answer here..." max="250"></textarea></br>
			</li>
			<li>
				Is your child in the habit of taking a nap? When?</br>
				<textarea type="text" name="napTakingName" id="napTakingId" placeholder="Enter answer here..." max="250"></textarea></br>
			</li>
			<li>
				Does your child play outside on a regular basis? Explain.</br>
				<textarea type="text" name="playOutsideName" id="playOutsideId" placeholder="Enter answer here..." max="250"></textarea></br>
			</li>
			<li>
				Do you have any household pets?</br>
				<input type="radio" name="RbHasPets" id="yesPetsId" onClick="show_hide('yes')"/> Yes
				<input type="radio" name="RbHasPets" id="noPetsId" onClick="show_hide('no')"/> No
				<div id="hasPetsDiv" style="display:none">
					Type(s):
					<input type='text' name='typeOfPetName' id='typeOfPetId' placeholder="Enter answer here..." max="50"/>
					Name(s):
					<input type='text' name='nameOfPetName' id='nameOfPetId' placeholder="Enter answer here..." max="50"/>
				</div>
			</li>
			<li>
				</br>Please list some of your child's interests:</br>
				<textarea name="childInterestsName" id="childInterestsId" cols="100" rows="2" max="250"
					placeholder="Enter answer here..."></textarea></br>		
			</li>
			<li>
				</br>Siblings:</br>
				<input type="text" name="siblingOneFirstName" id="siblingOneFirstId" placeholder="First name..." max="250"/>
				<input type="text" name="siblingsOneLastName" id="siblingOneLastId" placeholder="Last name..." max="250"/>
				<input type="text" name="siblingOneAgeName" id="silblingOneAgeId" placeholder="Age..." max="250"/></br>
			</li>
			<li>
				</br>Is there anythign else that you feel is important for the school to be aware of?</br>
				<textarea name="otherImportantName" id="otherImportantId" cols="100" rows="2" max="500"
					placeholder="Enter answer here..."></textarea></br>
			</li>
		</ul>
	</fieldset>
	<fieldset>
		How did you hear about Corvallis Montessori School?</br>
		<div class="hearAbout">
			<input type='radio' name='RbReference' id='parentId' onClick="show_hide('parent')"/> <label>Parent of a CMS student</label>
			<input type='text' name='TxtReference' id='parentTextId' style="display:none" placeholder="Specify name..." max="250"/>
			</br>
			<input type='radio' name='RbReference' id='friendId' onClick="show_hide('friend')"/> Friend
			<input type='text' name='TxtReference' id='friendTextId' style="display:none" placeholder="Specify name..." max="250"/>
			</br>
			<input type='radio' name='RbReference' id='newspaperId' onClick="show_hide('newspaper')"/> Newspaper
			<input type='text' name='TxtReference' id='newspaperTextId' style="display:none" placeholder="Specify name..." max="250"/>
			</br>
			<input type='radio' name='RbReference' id='internetId' onClick="show_hide('other')"/> Internet
			</br>
			<input type='radio' name='RbReference' id='posterId' onClick="show_hide('other')"/> Poster
			</br>
			<input type='radio' name='RbReference' id='otherId' onClick="show_hide('extra')"/> Other
			<input type='text' name='TxtReference' id='otherTextId' style="display:none" placeholder="Specify..." max="250"/>
		</div>		
	</fieldset>
</form>