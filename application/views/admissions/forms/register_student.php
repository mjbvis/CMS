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

	<?php
	/* display validation errors */
	$errors = validation_errors();
	if (!empty($errors)) {
		printf('<div class="validationBox">%s</div>', $errors);
	}
	?>

</script>
<div class="formBox">
	<form id='studentRegistration' method='post' accept-charset='UTF-8' class='clearfix'>
		<fieldset>
			<legend>Child's Information</legend>
			<ul>
				<li>
					<label>Name:</label>
					<input type="text" name="cFirstName" id="cFirstId" max="45" placeholder="First Name" value="<?php echo ($firstName); ?>" readonly="readonly" />
					<input type="text" name="cMiddleName" id="cMiddleId" max="45" value="<?php echo $middleName; ?>" readonly="readonly" />
					<input type="text" name="cLastName" id="cLastId" max="45" placeholder="Last Name" value="<?php echo ($lastName); ?>" readonly="readonly" /> </br>
				</li>
				<li>
					<label>Address:</label>
					<input type="text" name="cAddressName" id="cAddressId" max="100" placeholder="Address" /> </br>
				</li>
				<li>
					<label>Phone Number:</label>
					<input type="text" name="cPhoneNum" id="cPhoneId" max="15" placeholder="555-555-5555"/> </br>
				</li>
				<li>
					<label>Place of Birth:</label>
					<input type="text" name="cBirthplace" id="BirthplaceId" max="50" placeholder="City, State" /> </br>
				</li>
				<li>
					<label>Date of Birth:</label>
					<input type="text" name="cDOB" id="dobId" max="15" placeholder="01/01/2001" /> </br>
				</li>
				<li>
					<!-- blank label to help CSS -->
					<label></label>
					<input type='radio' name='cGender' id='male' value="M" /> Male
					<input type='radio' name='cGender' id='female' value="F" /> Female </br>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<legend>Program:</legend>
			<ul>
				<?php
					$i = 0;
					foreach($progGroups as $pGroup):
						$pGroupAttr = $pGroup->attributes();
						printf('<li>');
							printf('<label><h3>%s</h3></label></br>', $pGroupAttr['grouptitle']);
							printf('<ul>');
								foreach($pGroup->programs as $program):
									$programAttr = $program->attributes();
									printf('<li>');
										printf('<input type="radio" name="programChecked" id="programCheckbox%d" value="%d"/>', $i, $programAttr['programid']);
										printf('%s, %s - %s', $programAttr['days'], $programAttr['starttime'], $programAttr['endtime']);
									printf('</li>');
								endforeach;
							printf('</ul>');
						printf('</li>');
						$i++;
					endforeach;
				?>
			</ul>
		</fieldset>
		<fieldset>
			<legend>Emergency Contact:</legend>
			<ul>
				<li>
					<label>Full Name:</label>
					<input type="text" name="emergencyContactName1" id="emergencyContactName1" placeholder="Name..." max="250"></textarea></br>
				</li>
				<li>
					<label>Phone:</label>
					<input type="text" name="emergencyContactPhone1" id="emergencyContactPhone1" placeholder="Phone..." max="250"></textarea></br>
				</li>
							<li>
					<label>Relationship to child:</label>
					<input type="text" name="emergencyContactRelationship1" id="emergencyContactRelationship1" placeholder="Relationship..." max="250"></textarea></br>
				</li>
			</ul>
			</br>
			<ul>
				<li>
					<label>Full Name:</label>
					<input type="text" name="emergencyContactName2" id="emergencyContactName2" placeholder="Name..." max="250"></textarea></br>
				</li>
				<li>
					<label>Phone:</label>
					<input type="text" name="emergencyContactPhone2" id="emergencyContactPhone2" placeholder="Phone..." max="250"></textarea></br>
				</li>
							<li>
					<label>Relationship to child:</label>
					<input type="text" name="emergencyContactRelationship2" id="emergencyContactRelationship2" placeholder="Relationship..." max="250"></textarea></br>
				</li>
			</ul>
			</br>
			<ul>
				<li>
					<label>Full Name:</label>
					<input type="text" name="emergencyContactName3" id="emergencyContactName3" placeholder="Name..." max="250"></textarea></br>
				</li>
				<li>
					<label>Phone:</label>
					<input type="text" name="emergencyContactPhone3" id="emergencyContactPhone3" placeholder="Phone..." max="250"></textarea></br>
				</li>
				<li>
					<label>Relationship to child:</label>
					<input type="text" name="emergencyContactRelationship3" id="emergencyContactRelationship3" placeholder="Relationship..." max="250"></textarea></br>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<legend>Admission Information (new students only)</legend>
			<ul>
				<li>
					Does your child have previous school or day care experience?</br>
					Please list name and address:</br>
					<textarea name="daycareExperience" id="daycareExperienceId" placeholder="Enter answer here..." max="250"></textarea></br>
				</li>
				<li>
					What social experience does your child have (play groups, swimming, gym)?</br>
					<textarea name="socialExperience" id="socialExperienceId" placeholder="Enter answer here..." max="250"></textarea></br>
				</li>
				<li>
					In what ways do you comfort your child when upset?</br>
					<textarea name="comfortMethod" id="comfortChildId" placeholder="Enter answer here..." max="250"></textarea></br>
				</li>
				<li>
					Is your child able to care for his/her toileting needs? How?</br>
					<textarea name="toiletNeeds" id="toiletNeedsId" placeholder="Enter answer here..." max="250"></textarea></br>
				</li>
				<li>
					Is your child in the habit of taking a nap? When?</br>
					<textarea name="napTime" id="napTakingId" placeholder="Enter answer here..." max="250"></textarea></br>
				</li>
				<li>
					Does your child play outside on a regular basis? Explain.</br>
					<textarea name="playOutside" id="playOutsideId" placeholder="Enter answer here..." max="250"></textarea></br>
				</li>
				<li>
					Do you have any household pets?</br>
					<input type="radio" name="HasPets" id="yesPetsId" value="1" onClick="show_hide('yes')"/> Yes
					<input type="radio" name="HasPets" id="noPetsId" value="0" onClick="show_hide('no')"/> No
					<div id="hasPetsDiv" style="display:none">
						Type(s):
						<input type='text' name='petType' id='typeOfPetId' placeholder="Enter answer here..." max="50"/>
						Name(s):
						<input type='text' name='petName' id='nameOfPetId' placeholder="Enter answer here..." max="50"/>
					</div>
				</li>
				<li>
					</br>Please list some of your child's interests:</br>
					<textarea name="childInterestsName" id="childInterestsId" cols="100" rows="2" max="250"
						placeholder="Enter answer here..."></textarea></br>		
				</li>
				<li>
					</br>Siblings:</br>
					<input type="text" name="siblingOneName" id="siblingOneFirstId" placeholder="Name..." max="250"/>
					<input type="text" name="siblingOneAge" id="silblingOneAgeId" placeholder="Age..." max="250"/></br>
				</li>
				<li>
					</br>Is there anythign else that you feel is important for the school to be aware of?</br>
					<textarea name="otherImportantInfo" id="otherImportantId" cols="100" rows="2" max="500"
						placeholder="Enter answer here..."></textarea></br>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			How did you hear about Corvallis Montessori School?</br>
			<div class="hearAbout">
				<input type='radio' name='referenceType' id='parentId' onClick="show_hide('parent')"/> <label>Parent of a CMS student</label>
				<input type='text' name='referenceName' id='parentTextId' style="display:none" placeholder="Specify name..." max="250"/>
				</br>
				<input type='radio' name='referenceType' id='friendId' onClick="show_hide('friend')"/> Friend
				<input type='text' name='referenceName' id='friendTextId' style="display:none" placeholder="Specify name..." max="250"/>
				</br>
				<input type='radio' name='referenceType' id='newspaperId' onClick="show_hide('newspaper')"/> Newspaper
				<input type='text' name='referenceName' id='newspaperTextId' style="display:none" placeholder="Specify name..." max="250"/>
				</br>
				<input type='radio' name='referenceType' id='internetId' onClick="show_hide('other')"/> Internet
				</br>
				<input type='radio' name='referenceType' id='posterId' onClick="show_hide('other')"/> Poster
				</br>
				<input type='radio' name='referenceType' id='otherId' onClick="show_hide('extra')"/> Other
				<input type='text' name='referenceName' id='otherTextId' style="display:none" placeholder="Specify..." max="250"/>
			</div>		
		</fieldset>
		<input type="submit" value="Save and Continue" name="registerStudent" class="submit"/>
	</form>
</div>