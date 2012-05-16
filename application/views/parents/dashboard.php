<script src="http://code.jquery.com/jquery-1.7.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.bbq.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.timepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/carbo.grid.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/carbo.form.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/carbo/jquery-ui-1.8.16.custom.css" type="text/css" media="all" />
<link href="<?php echo base_url(); ?>css/carbo.grid.css" rel="stylesheet" type="text/css" media="all" />
<!--[if lt IE 7]><link href="<?php echo base_url(); ?>css/carbo.grid.ie6.css" rel="stylesheet" type="text/css" media="all" /><![endif]-->
<link href="<?php echo base_url(); ?>css/carbo.form.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo base_url(); ?>css/960.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />

<div id="content">

	<div id="waitlistForm">
		<label>Waitlisted:</label></br>
		<?php if (isset($wlGrid)) echo $wlGrid; ?>
	</div>
	
	<div id="preEnrolledForm">
		<label>Pre-Enrolled:</label></br>
		<?php if (isset($preEnrollGrid)) echo $preEnrollGrid; ?>
	</div>
	
	<div id="registeredForm">
		<label>Registered:</label></br>
		<?php if (isset($registeredGrid)) echo $registeredGrid; ?>
	</div>
	
	<div id="NotificationForm">
		<label>Registered:</label></br>
		<?php if (isset($NotificationGrid)) echo $NotificationGrid; ?>
	</div>
	
	<div id="VolunteeringForm">
		<label>Volunteer Log:</label></br>
		<?php if (isset($volunteeringGrid)) echo $volunteeringGrid; ?>
	</div>

</div>
