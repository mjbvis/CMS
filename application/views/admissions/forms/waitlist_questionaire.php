<?php
/**
 * Is Set Not Empty Function
 * Use: Verify if a variable is set and is not empty.
 * @param mixed $var - Reference of a variable to be checked.
 * @return bool - True if the variable is set AND not empty.  False otherwise.
 */
if (!function_exists('isset_not_empty')) {
	function isset_not_empty(&$var) {
		return (isset($var) && !empty($var));
	}

}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="Robots" content="noindex, nofollow, noarchive">
		<meta name="Description" content="Corvallis Montessori School">
		<meta name="Author" content="Corvallis Montessori School">
		<meta name="Rating" content="General">
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<title><?php echo((isset_not_empty($title) ? "$title | CMS" : "CMS"));?></title>
		<link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/screen.css');?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/forms/screen.css');?>" type="text/css" media="screen" />
		<script type="text/javascript" src="assets/js/jquery.autoheight.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
		
	</head>
	<body>
		
	<div class="formBox">
		<?php
		/* display validation errors */
		$errors = validation_errors();
		if (!empty($errors)) {
			printf('<div class="validationBox">%s</div>', $errors);
		}
		?>
	
		<form id='studWaitlistQuestionaire' method='post' accept-charset='UTF-8' class='clearfix'>
			<fieldset>
				<legend>
					Child's Name:
				</legend>
				<label for="cFirstId">First Name:&nbsp;&nbsp;&nbsp;</label>
				<input type="text" name="cFirstName" id="cFirstId" max="45" placeholder="First Name" value="<?php echo set_value('cFirstName');?>" />
				<br><br>
				<label for="cMiddleId">Middle Name: </label>
				<input type="text" name="cMiddleName" id="cMiddleId" max="45" placeholder="Middle Name" value="<?php echo set_value('cMiddleName');?>" />
				<br><br>
				<label for="cLastId">Last Name:&nbsp;&nbsp;&nbsp;</label>
				<input type="text" name="cLastName" id="cLastId" max="45" placeholder="Last Name" value="<?php echo set_value('cLastName');?>" />
				</br> </br>
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
												printf('<input type="radio" name="programChecked" id="programCheckbox%d" value="%d" %s />', $i, $programAttr['programid'], set_radio('programChecked', $programAttr['programid']));
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
				<a class='fancyframe' href="<?php echo base_url('admissions/policy')?>">Click here to view Montessori values</a></br></br>
				How well do you agree with the Montessori values?</br>
				<input type="radio" name="pAgreement" value="1" align="vertical" <?php echo set_radio('pAgreement', '1'); ?> \>Agree</input>
				<input type="radio" name="pAgreement" value="2" aligh="vertical" <?php echo set_radio('pAgreement', '2'); ?> \>Unsure</input>
				<input type="radio" name="pAgreement" value="3" align="vertical" <?php echo set_radio('pAgreement', '3'); ?> \>Disagree</input>
			</fieldset>
			<input type="submit" value="Save and Continue" name="waitlistQuestionaire" class="submit"/>
		</form>
	</div>
</body>
</html>
