<script type="text/javascript">
function show_hide(value) {
	switch(value){
		case 'show_specify':
			document.getElementById('referenceNotes').style.display="block";	
			break;
		case 'hide_specify':
			document.getElementById('referenceNotes').style.display="none";
			document.getElementById('referenceNotes').value = null;
			break;	
		default:
			break;
	}
}
</script>

<div class="formBox">
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
                    <input type='text' name='contactDateTime' id='contactDateId' max='15' placeholder="01/01/2001" value="<?php echo set_value('contactDateTime'); ?>"/>
                    </br>
                </li>
                <li>
                    <label>Phone Number:</label>
                    <input type='text' name='phoneNumber' id='phoneId' max='15' placeholder="555-555-5555" value="<?php echo set_value('phoneNumber'); ?>" />
                    </br>
                </li>
                <li>
                    <label>Visit Date:</label>
                    <input type='text' name='visitDateTime' id='visitDateId' max='15' placeholder="01/01/2001" value="<?php echo set_value('visitDateTime'); ?>" />
                    </br>
                </li>
                <li>
                    <label>Email:</label>
                    <input type='text' name='email' id='emailId' max='50' placeholder="email@address.com" value="<?php echo set_value('email'); ?>"/>
                    </br>
                </li>
                <li>
                    How did you hear about CMS?</br>
                    <div class="radioButtons">
                        <input type='radio' name='learnedAboutName' id='webSearchId' value="webSearch" onClick="show_hide('hide_specify')" <?php echo set_value('learnedAboutName', "webSearch"); ?> />
                        Web Search
                        <input type='radio' name='learnedAboutName' id='cmsFamilyId' value="cmsFamily" onClick="show_hide('hide_specify')" <?php echo set_value('learnedAboutName', "cmsFamily"); ?> />
                        CMS Family
                        <input type='radio' name='learnedAboutName' id='friendsId' value="friends" onClick="show_hide('hide_specify')" <?php echo set_value('learnedAboutName', "friends"); ?> />
                        Friends
                        <input type='radio' name='learnedAboutName' id='adInRadioId' value="ad" onClick="show_hide('show_specify')" <?php echo set_value('learnedAboutName', "ad"); ?> />
                        Ad In
                        <input type='radio' name='learnedAboutName' id='otherRadioId' value="other" onClick="show_hide('show_specify')" <?php echo set_value('learnedAboutName', "other"); ?> />
                        Other
                        <input type='text' name='referenceNote' id='referenceNotes' value="<?php echo set_value('referenceNote'); ?>" style="display:none" placeholder="Notes..." max="250"/>
                    </div>                 
                </li>
            </ul>
        </fieldset>
	
		<fieldset>
			Level of Interest:
			<div class="radioButtons">
				<input type="radio" name="interestLevel" id="interestLowId" value="low" <?php echo set_value('interestLevel', "low"); ?> /> Low
				<input type="radio" name="interestLevel" id="interestMediumId" value="medium" <?php echo set_value('interestLevel', "medium"); ?> /> Medium
				<input type="radio" name="interestLevel" id="interestHighId" value="high" <?php echo set_value('interestLevel', "high"); ?> /> High </br>
			</div>
			
			Understanding of Montessori:
			<div class="radioButtons">
			<input type="radio" name="understandingLevel" id="understandingLowId" value="little" <?php echo set_value('understandingLevel', "little"); ?> /> Little
			<input type="radio" name="understandingLevel" id="understandingMediumId" value="average" <?php echo set_value('understandingLevel', "average"); ?> /> Average
			<input type="radio" name="understandingLevel" id="understandingHighId" value="high" <?php echo set_value('understandingLevel', "high"); ?> /> High </br>
			</div>
			
			Willingness to learn more:
			<div class="radioButtons">
			<input type="radio" name="willingnessLevel" id="willingnessLowId" value="low" <?php echo set_value('willingnessLevel', "low"); ?> /> Low
			<input type="radio" name="willingnessLevel" id="willingnessMediumId" value="medium" <?php echo set_value('willingnessLevel', "medium"); ?> /> Medium
			<input type="radio" name="willingnessLevel" id="willingnessHighId" value="high" <?php echo set_value('willingnessLevel', "high"); ?> /> High </br>
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
				<input type="checkbox" name="learningNotes" id="independentId" value="independent" <?php echo set_value('learningNotes', "independent"); ?>/> In Depth Learning
				<input type="checkbox" name="learningNotes" id="ownPaceId" value="ownPace" <?php echo set_value('learningNotes', "ownPace"); ?>/> At Own Pace
				<input type="checkbox" name="learningNotes" id="handsOnId" value="handsOn" <?php echo set_value('learningNotes', "handsOn"); ?>/> Hands On
				<input type="checkbox" name="learningNotes" id="mixedAgesId" value="mixedAges" <?php echo set_value('learningNotes', "mixedAges"); ?>/> Mixed Ages </br></br>
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
					<input type="text" name="observationDateTime" id="observationDateId" max="15" placeholder="01/01/2001" value="<?php echo set_value('observationDateTime'); ?>"/> </br>
				</li>
				<li>
					<label>Class:</label>
					<input type="text" name="classroom" id="classId" max="50" placeholder="Name of Classroom" value="<?php echo set_value('classroom'); ?>"/> </br>
				</li>
				<li>
					<label>Attended:</label>
					<div class="radioButtons">
						<input type="radio" name="attendedRadio" id="attendedRadioId" value="yes" <?php echo set_value('attendedRadio', "yes"); ?> /> Yes
						<input type="radio" name="attendedRadio" id="attendedRadioId" value="no" <?php echo set_value('attendedRadio', "no"); ?> /> No
					</div>
				</li>
				<li>
					<label>On Time:</label>
					<div class="radioButtons">
						<input type="radio" name="onTimeRadio" id="onTimeRadioId" value="yes" <?php echo set_value('onTimeRadio', "yes"); ?> /> Yes
						<input type="radio" name="onTimeRadio" id="onTimeRadioId" value="no" <?php echo set_value('onTimeRadio', "no"); ?> /> No
					</div>
				</li>
				<li>
					<label>Interview Date:</label> 
					<input type="text" name="interviewDateTime" id="interviewDateId" max="15" placeholder="01/01/2001" value="<?php echo set_value('interviewDateTime'); ?>" /> </br>
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<ul>
				<li>
					Date Application Received:
					<input type="text" name="appReceivedDateTime" id="appReceivedId" max="15" placeholder="01/01/2001" value="<?php echo set_value('appReceivedDateTime'); ?>"/> </br>
				</li>
				<li>
					Date Application Fee Received:
					<input type="text" name="feeReceivedDateTime" id="feeReceivedId" max="15" placeholder="01/01/2001" value="<?php echo set_value('feeReceivedDateTime'); ?>"/> </br>
				</li>
			</ul>
		</fieldset>
		
			<input type="submit" value="Save and Continue" name="interviewObservationForm" class="submit"/>
	</form>
</div>
