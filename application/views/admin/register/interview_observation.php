<div class="formBox">
	
	<?php
	/* display validation errors */
	$errors = validation_errors();
	if (!empty($errors)) {
		printf('<div class="validationBox">%s</div>', $errors);
	}
	?>
	
	<form id='parentInterviewObservationForm' method="post" accept-charset='UTF-8' class="clearfix">
        <fieldset>
            <legend>
                Contact Information
            </legend>
            <ul>
                <li>
                    Parent's Names:</br>
                    <textarea name="pNames" id="parentNames"
                    	placeholder="Name, Name, ..." cols="100" rows="5" max="250" ><?php
							echo set_value('pNames'); ?></textarea></br>
                    </br>
                </li>
                <li>
                    Children names/ages:</br>
                    <textarea name="namesAndAges" id="namesAndAgesId"
                    	placeholder="Name age, Name age, ..." cols="100" rows="5" max="250" ><?php
							echo set_value('namesAndAges'); ?></textarea></br>
                    </br>
                </li>
                <li>
                    <label>Date first contacted:</label>
                    <input type='text' name='contactDateTime' id='contactDateId' max='15' placeholder="mm/dd/yyyy" value="<?php echo set_value('contactDateTime'); ?>"/>
                    </br>
                </li>
                <li>
                    <label>Phone Number:</label>
                    <input type='text' name='phoneNumber' id='phoneId' max='15' placeholder="555-555-5555" value="<?php echo set_value('phoneNumber'); ?>" />
                    </br>
                </li>
                <li>
                    <label>Visit Date:</label>
                    <input type='text' name='visitDateTime' id='visitDateId' max='15' placeholder="mm/dd/yyyy" value="<?php echo set_value('visitDateTime'); ?>" />
                    </br>
                </li>
                <li>
                    <label>Email:</label>
                    <input type='text' name='email' id='emailId' max='50' placeholder="email@address.com" value="<?php echo set_value('email'); ?>"/>
                	</br></br>
                </li>
                <li>
                    How did you hear about CMS?</br>
                    <div class="radioButtons">
                    	<!-- hidden fields provide values for unchecked checkboxes -->
                    	<input type="hidden" name="webSearch" value="0" />
                    	<input type="hidden" name="cmsFamily" value="0" />
                    	<input type="hidden" name="friends" value="0" />
                    	<input type="hidden" name="adIn" value="0" />
                    	<input type="hidden" name="otherRef" value="0" />
                        <input type='checkbox' name='webSearch' id='webSearchId' value="1" onClick="show_hide('hide_specify')" <?php echo set_checkbox('webSearch', "1"); ?> /> Web Search
                        <input type='checkbox' name='cmsFamily' id='cmsFamilyId' value="1" onClick="show_hide('hide_specify')" <?php echo set_checkbox('cmsFamily', "1"); ?> /> CMS Family
                        <input type='checkbox' name='friends' id='friendsId' value="1" onClick="show_hide('hide_specify')" <?php echo set_checkbox('friends', "1"); ?> /> Friends</br>
                        <input type='checkbox' name='adIn' id='adInId' value="1" onClick="show_hide('show_specify')" <?php echo set_checkbox('adIn', "1"); ?> /> Ad In:
                        <input type='text' name='adInRefNote' id='adInReferenceNote' value="<?php echo set_value('adInRefNote'); ?>" placeholder="Notes..." max="250"/>
                        <input type='checkbox' name='otherRef' id='otherRefId' value="1" onClick="show_hide('show_specify')" <?php echo set_checkbox('otherRef', "1"); ?> /> Other:
                        <input type='text' name='otherRefNote' id='otherReferenceNote' value="<?php echo set_value('otherRefNote'); ?>" placeholder="Notes..." max="250"/>
                    </div>                 
                </li>
            </ul>
        </fieldset>
	
		<fieldset>
			Level of Interest:
			<div class="radioButtons">
				<input type="radio" name="interestLevel" id="interestLowId" value="low" <?php echo set_radio('interestLevel', "low"); ?> /> Low
				<input type="radio" name="interestLevel" id="interestMediumId" value="medium" <?php echo set_radio('interestLevel', "medium"); ?> /> Medium
				<input type="radio" name="interestLevel" id="interestHighId" value="high" <?php echo set_radio('interestLevel', "high"); ?> /> High </br>
			</div>
			
			Understanding of Montessori:
			<div class="radioButtons">
			<input type="radio" name="understandingLevel" id="understandingLowId" value="little" <?php echo set_radio('understandingLevel', "little"); ?> /> Little
			<input type="radio" name="understandingLevel" id="understandingMediumId" value="average" <?php echo set_radio('understandingLevel', "average"); ?> /> Average
			<input type="radio" name="understandingLevel" id="understandingHighId" value="high" <?php echo set_radio('understandingLevel', "high"); ?> /> High </br>
			</div>
			
			Willingness to learn more:
			<div class="radioButtons">
			<input type="radio" name="willingnessLevel" id="willingnessLowId" value="low" <?php echo set_radio('willingnessLevel', "low"); ?> /> Low
			<input type="radio" name="willingnessLevel" id="willingnessMediumId" value="medium" <?php echo set_radio('willingnessLevel', "medium"); ?> /> Medium
			<input type="radio" name="willingnessLevel" id="willingnessHighId" value="high" <?php echo set_radio('willingnessLevel', "high"); ?> /> High </br>
			</div>
		</fieldset>
		<fieldset>	
			<ul>
				<li>
					If Moving:</br>
    			    <label>City/State/School</label>	
    				<input type="text" name="movingCity" id="movingCityId" max="50" placeholder="city" value="<?php echo set_value('movingCity'); ?>"/> 
    				<input type="text" name="movingState" id="movingStateId" max="50" placeholder="state" value="<?php echo set_value('movingState'); ?>"/>
    				<input type="text" name="movingSchool" id="movingSchoolId" max="100" placeholder="school" value="<?php echo set_value('movingSchool'); ?>"/> </br>
				</li>
			</ul>
			
	     	Notes:
	     	<div class="radioButtons">
 		        <!-- hidden fields provide values for unchecked checkboxes -->
            	<input type="hidden" name="independent" value="0" />
            	<input type="hidden" name="ownPace" value="0" />
            	<input type="hidden" name="handsOn" value="0" />
            	<input type="hidden" name="mixedAges" value="0" />
				<input type="checkbox" name="independent" id="independentId" value="1" <?php echo set_checkbox('independent', "1"); ?>/> In Depth Learning
				<input type="checkbox" name="ownPace" id="ownPaceId" value="1" <?php echo set_checkbox('ownPace', "1"); ?>/> At Own Pace
				<input type="checkbox" name="handsOn" id="handsOnId" value="1" <?php echo set_checkbox('handsOn', "1"); ?>/> Hands On
				<input type="checkbox" name="mixedAges" id="mixedAgesId" value="1" <?php echo set_checkbox('mixedAges', "1"); ?>/> Mixed Ages </br></br>
	        </div>
			
			Montessori impressions: </br>
				<textarea name="montessoriImpressions" id="montessoriImpressionsId" cols="100" rows="2" max="1000" 
					placeholder="Impressions..."><?php
						echo set_value('montessoriImpressions'); ?></textarea></br>
					
			Interview impressions: </br>
				<textarea name="interviewImpressions" id="interviewsImpressionsId" cols="100" rows="2" max="1000"
					placeholder="Impressions..."><?php
						echo set_value('interviewImpressions'); ?></textarea></br>
						
		</fieldset>
		
		<fieldset>
			<legend>Classroom Observation:</legend>
			<ul>
				<li>
					<label>Date:</label>
					<input type="text" name="observationDateTime" id="observationDateId" max="15" placeholder="mm/dd/yyyy" value="<?php echo set_value('observationDateTime'); ?>"/> </br>
				</li>
				<li>
					<label>Class:</label>
					<div class="radioButtons">
						<?php
						printf('<select name="classroom">');
						printf('<option value="" %s>select a class</option>', set_select('classroom', '', TRUE));
						foreach($classes as $class):
							$classAttr = $class->attributes();
							printf('<option value="%s" %s>%s</option>', $classAttr['classid'], set_select('classroom', $classAttr['classid']), $classAttr['classname']);
						endforeach;
						printf('</select>');
						?>
					</div>
					
					
					
					<!-- <input type="text" name="classroom" id="classId" max="50" placeholder="Name of Classroom" value="<?php echo set_value('classroom'); ?>"/> </br> -->
				</li>
				<li>
					<label>Attended:</label>
					<div class="radioButtons">
						<input type="radio" name="attendedRadio" id="attendedRadioId" value="1" <?php echo set_radio('attendedRadio', "1"); ?> /> Yes
						<input type="radio" name="attendedRadio" id="attendedRadioId" value="0" <?php echo set_radio('attendedRadio', "0"); ?> /> No
					</div>
				</li>
				<li>
					<label>On Time:</label>
					<div class="radioButtons">
						<input type="radio" name="onTimeRadio" id="onTimeRadioId" value="1" <?php echo set_radio('onTimeRadio', "1"); ?> /> Yes
						<input type="radio" name="onTimeRadio" id="onTimeRadioId" value="0" <?php echo set_radio('onTimeRadio', "0"); ?> /> No
					</div>
				</li>
				<li>
					<label>Interview Date:</label> 
					<input type="text" name="interviewDateTime" id="interviewDateId" max="15" placeholder="mm/dd/yyyy" value="<?php echo set_value('interviewDateTime'); ?>" /> </br>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<ul>
				<li>
					Date Application Received:
					<input type="text" name="appReceivedDateTime" id="appReceivedId" max="15" placeholder="mm/dd/yyyy" value="<?php echo set_value('appReceivedDateTime'); ?>"/> </br>
				</li>
				<li>
					Date Application Fee Received:
					<input type="text" name="feeReceivedDateTime" id="feeReceivedId" max="15" placeholder="mm/dd/yyyy" value="<?php echo set_value('feeReceivedDateTime'); ?>"/> </br>
				</li>
			</ul>
		</fieldset>
		
			<input type="submit" value="Save and Continue" name="interviewObservationForm" class="submit"/>
	</form>
</div>
