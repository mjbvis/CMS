<script type="text/javascript">

$(document).ready(function() {                                         
	$("#yesPetsId").click(function() { 
		$('#hasPetsDiv').show();
	});
    
	$("#noPetsId").click(function() { 
		$('#hasPetsDiv').hide();
	});

	$("#parentId, #friendId, #newspaperId, #otherId").click(function() { 
		$('#specifyTextId').show();
	});
	
	$("#internetId, #posterId").click(function() { 
		$('#specifyTextId').hide();
	});
});

</script>
<div class="formBox">

	<?php
	/* display validation errors */
	$errors = validation_errors();
	if (!empty($errors)) {
		printf('<div class="validationBox">%s</div>', $errors);
	}
	?>
	
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
					<input type="text" name="cAddress" id="cAddressId" max="100" placeholder="Address" value="<?php echo set_value('cAddress'); ?>"/> </br>
				</li>
				<li>
					<label>Phone Number:</label>
					<input type="text" name="cPhoneNum" id="cPhoneId" max="15" placeholder="555-555-5555" value="<?php echo set_value('cPhoneNum'); ?>" /> </br>
				</li>
				<li>
					<label>Place of Birth:</label>
					<input type="text" name="cBirthplace" id="BirthplaceId" max="50" placeholder="City, State" value="<?php echo set_value('cBirthplace'); ?>" /> </br>
				</li>
				<li>
					<label>Date of Birth:</label>
					<input type="text" name="cDOB" id="dobId" max="15" placeholder="01/01/2001" value="<?php echo set_value('cDOB'); ?>" /> </br>
				</li>
				<li>
					<!-- blank label to help CSS -->
					<label></label>
					<input type='radio' name='cGender' id='male' value="M" <?php echo set_radio('cGender', "M"); ?> /> Male
					<input type='radio' name='cGender' id='female' value="F" <?php echo set_radio('cGender', "F"); ?> /> Female </br>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<legend>Program:</legend>
			<ul>
				<?php
					$schoolInfoAttr = $schoolInformation->attributes();
				
					$i = 0;
					foreach($academicLevels as $level):
						$levelAttr = $level->attributes();
						printf('<li>');
							printf('<label><h3>%s</h3></label></br>', $levelAttr['academiclevelname']);
							printf('<ul>');
								foreach($level->programs as $program):
									$programAttr = $program->attributes();
									// only display enabled Programs.
									// NOTE: these are not filtered out at this point
									if($programAttr['enabled'] == 1 && $programAttr['academicyear'] == $schoolInfoAttr['academicyear']):
										printf('<li>');
											printf('<input type="radio" name="programChecked" id="programCheckbox%d" value="%d" %s />', $i, $programAttr['programid'], ($programAttr['programid'] == $progSelected) ? set_radio('programChecked', $programAttr['programid'], TRUE) : set_radio('programChecked', $programAttr['programid']));
											printf('%s, %s - %s,      $%s', $programAttr['days'], $programAttr['starttime'], $programAttr['endtime'], $programAttr['tuition']);
										printf('</li>');
									endif;
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
					<input type="text" name="emergencyContactName1" id="emergencyContactName1" value="<?php echo set_value('emergencyContactName1'); ?>" placeholder="Name..." max="250" /></br>
				</li>
				<li>
					<label>Phone:</label>
					<input type="text" name="emergencyContactPhone1" id="emergencyContactPhone1" value="<?php echo set_value('emergencyContactPhone1'); ?>" placeholder="Phone..." max="250" /></br>
				</li>
							<li>
					<label>Relationship to child:</label>
					<input type="text" name="emergencyContactRelationship1" id="emergencyContactRelationship1" value="<?php echo set_value('emergencyContactRelationship1'); ?>" placeholder="Relationship..." max="250" /></br>
				</li>
			</ul>
			</br>
			<ul>
				<li>
					<label>Full Name:</label>
					<input type="text" name="emergencyContactName2" id="emergencyContactName2" value="<?php echo set_value('emergencyContactName2'); ?>" placeholder="Name..." max="250" /></br>
				</li>
				<li>
					<label>Phone:</label>
					<input type="text" name="emergencyContactPhone2" id="emergencyContactPhone2" value="<?php echo set_value('emergencyContactPhone2'); ?>" placeholder="Phone..." max="250" /></br>
				</li>
							<li>
					<label>Relationship to child:</label>
					<input type="text" name="emergencyContactRelationship2" id="emergencyContactRelationship2" value="<?php echo set_value('emergencyContactRelationship2'); ?>" placeholder="Relationship..." max="250" /></br>
				</li>
			</ul>
			</br>
			<ul>
				<li>
					<label>Full Name:</label>
					<input type="text" name="emergencyContactName3" id="emergencyContactName3" value="<?php echo set_value('emergencyContactName3'); ?>" placeholder="Name..." max="250" /></br>
				</li>
				<li>
					<label>Phone:</label>
					<input type="text" name="emergencyContactPhone3" id="emergencyContactPhone3" value="<?php echo set_value('emergencyContactPhone3'); ?>" placeholder="Phone..." max="250" /></br>
				</li>
				<li>
					<label>Relationship to child:</label>
					<input type="text" name="emergencyContactRelationship3" id="emergencyContactRelationship3" value="<?php echo set_value('emergencyContactRelationship3'); ?>" placeholder="Relationship..." max="250" /></br>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<legend>Admission Information (new students only)</legend>
			<ul>
				<li>
					Does your child have previous school or day care experience?</br>
					Please list name and address:</br>
					<textarea name="daycareExperience" id="daycareExperienceId" placeholder="Enter answer here..." max="250"><?php echo set_value('daycareExperience'); ?></textarea></br>
				</li>
				<li>
					What social experience does your child have (play groups, swimming, gym)?</br>
					<textarea name="socialExperience" id="socialExperienceId" placeholder="Enter answer here..." max="250"><?php echo set_value('socialExperience'); ?></textarea></br>
				</li>
				<li>
					In what ways do you comfort your child when upset?</br>
					<textarea name="comfortMethod" id="comfortChildId" placeholder="Enter answer here..." max="250"><?php echo set_value('comfortMethod'); ?></textarea></br>
				</li>
				<li>
					Is your child able to care for his/her toileting needs? How?</br>
					<textarea name="toiletNeeds" id="toiletNeedsId" placeholder="Enter answer here..." max="250"><?php echo set_value('toiletNeeds'); ?></textarea></br>
				</li>
				<li>
					Is your child in the habit of taking a nap? When?</br>
					<textarea name="napTime" id="napTakingId" placeholder="Enter answer here..." max="250"><?php echo set_value('napTime'); ?></textarea></br>
				</li>
				<li>
					Does your child play outside on a regular basis? Explain.</br>
					<textarea name="playOutside" id="playOutsideId" placeholder="Enter answer here..." max="250"><?php echo set_value('playOutside'); ?></textarea></br>
				</li>
				<li>
					Do you have any household pets?</br>
					<input type="radio" name="HasPets" id="yesPetsId" value="1" <?php echo set_radio('HasPets', "1"); ?> /> Yes
					<input type="radio" name="HasPets" id="noPetsId" value="0" <?php echo set_radio('HasPets', "0"); ?> /> No
					<div id="hasPetsDiv" style="display:none">
						Type(s):
						<input type='text' name='petType' id='typeOfPetId' value="<?php echo set_value('petType'); ?>" placeholder="Enter answer here..." max="50"/>
						Name(s):
						<input type='text' name='petName' id='nameOfPetId' value="<?php echo set_value('petName'); ?>" placeholder="Enter answer here..." max="50"/>
					</div>
				</li>
				<li>
					</br>Please list some of your child's interests:</br>
					<textarea name="childInterestsName" id="childInterestsId" cols="100" rows="2" max="250"
						placeholder="Enter answer here..."><?php echo set_value('childInterestsName'); ?></textarea></br>		
				</li>
				<li>
					</br>Siblings:</br>
					<input type="text" name="siblingOneName" id="siblingOneFirstId" value="<?php echo set_value('siblingOneName'); ?>" placeholder="Name..." max="250"/>
					<input type="text" name="siblingOneAge" id="silblingOneAgeId" value="<?php echo set_value('siblingOneAge'); ?>" placeholder="Age..." max="250"/></br>
				</li>
				<li>
					</br>Is there anything else that you feel is important for the school to be aware of?</br>
					<textarea name="otherImportantInfo" id="otherImportantId" cols="100" rows="2" max="500"
						placeholder="Enter answer here..."><?php echo set_value('otherImportantInfo'); ?></textarea></br>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			How did you hear about Corvallis Montessori School?</br>
			<div class="hearAbout">
				<input type='radio' name='referenceType' id='parentId' value="Parent" <?php echo set_radio('referenceType', "Parent"); ?>/> <label>Parent of a CMS student</label>
				</br>
				<input type='radio' name='referenceType' id='friendId' value="Friend" <?php echo set_radio('referenceType', "Friend"); ?>/> Friend
				</br>
				<input type='radio' name='referenceType' id='newspaperId' value="Newspaper" <?php echo set_radio('referenceType', "Newspaper"); ?> /> Newspaper
				</br>
				<input type='radio' name='referenceType' id='internetId' value="Internet" <?php echo set_radio('referenceType', "Internet"); ?> /> Internet
				</br>
				<input type='radio' name='referenceType' id='posterId' value="Poster" <?php echo set_radio('referenceType', "Poster"); ?> /> Poster
				</br>
				<input type='radio' name='referenceType' id='otherId' value="Other" <?php echo set_radio('referenceType', "Other"); ?>/> Other
				</br>
				<input type='text' name='referenceName' id='specifyTextId' value="<?php echo set_value('referenceName'); ?>" style="display:none" placeholder="Specify..." max="250"/>
			</div>		
		</fieldset>
		<input type="submit" value="Save and Continue" name="registerStudent" class="submit"/>
	</form>
</div>