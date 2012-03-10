<form id='studWaitlistQuestionaire' action='policyConsent.php' method='post' accept-charset='UTF-8'>
	<fieldset>
		Child's Name: 
			<input type="text" name="cFirstName" id="cFirstId" max="50" placeholder="First Name"/>
			<input type="text" name="cLastName" id="cLastId" max="50" placeholder="Last Name" /> </br> </br>

			<? $i = 0; ?>
			<?php foreach($wlQuestions as $q): ?>
				<?
					$i++;
					// print question
					$attributes = $q->attributes();
					echo $attributes['questiontext'] . '</br>';
				?>
				
				<!--Question Textarea-->
				<textarea name="<?="q" . $i . "answer"; ?>" id="<?="q" . $i . "ID"; ?>" placeholder="Enter Answer Here..." cols="100" rows="5" max="250" ></textarea></br>

			<?php endforeach; ?>
	</fieldset>
</form>