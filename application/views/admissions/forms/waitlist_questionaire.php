<div class="formBox">
	<?php
	$errors = validation_errors();
	if (!empty($errors)) {
		printf('<div class="validationBox">%s</div>', $errors);
	}
	?>

	<form id='studWaitlistQuestionaire'  method='post' accept-charset='UTF-8' class='clearfix'>
		<fieldset>
			<legend>
				Child's Name:
			</legend>
			<input type="text" name="cFirstName" id="cFirstId" max="45" placeholder="First Name" value="<?php echo set_value('cFirstName');?>" />
			<input type="text" name="cMiddleName" id="cMiddleId" max="45" placeholder="Middle Name" value="<?php echo set_value('cMiddleName');?>" />
			<input type="text" name="cLastName" id="cLastId" max="45" placeholder="Last Name" value="<?php echo set_value('cLastName');?>" />
			</br> </br>
		</fieldset>
		<fieldset>
			<legend>
				Waitlist Questionaire:
			</legend>
			<?php
			$i = 0;
			foreach($wlQuestions as $q):
				// print question
				$attributes = $q->attributes();
				echo $attributes['questiontext'] . '</br>';
			?>
			<!--Question Textarea-->
			<textarea name="<?php echo('q' . $i . 'answer');?>" id="<?php echo('q' . $i . 'ID');?>"
				placeholder="Enter Answer Here..." cols="100" rows="5" max="250" ><?php
					echo set_value('q' . $i . 'answer'); ?></textarea></br>
			<?php
				$i++;
			endforeach;
			?>
		</fieldset>
		<fieldset>
			<?php printf('<a href="%s" target="_blank">%s</a></br></br>', base_url('admissions/policy'), 'Click here to view Montessori values'); ?>
			How well do you agree with the Montessori values?</br>
			<input type="radio" name="pAgreement" value="1" align="vertical" <?php echo set_radio('pAgreement', '1'); ?> >Agree</input>
			<input type="radio" name="pAgreement" value="2" aligh="vertical" <?php echo set_radio('pAgreement', '2'); ?> >Unsure</input>
			<input type="radio" name="pAgreement" value="3" align="vertical" <?php echo set_radio('pAgreement', '3'); ?> >Disagree</input>
		</fieldset>
		<input type="submit" value="Save and Continue" name="waitlist_questionaire" class="submit"/>
	</form>
</div>
