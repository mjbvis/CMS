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
    <div id='adminDashWaitlist'>
    	<label>Wait List</label>
    	<?php if (isset($wlGrid)) echo $wlGrid; ?>
    </div>
   </br>
    <div id='adminDashPreEnrolled'>
    	<label>Pre-Enrolled</label>
    	<?php if (isset($preEnrollGrid)) echo $preEnrollGrid; ?>
    </div>
    </br>
    <div id='adminDashProspect'>
    	<label>test</label>
    	<?php if (isset($volunteerGrid)) echo $volunteerGrid; ?>
    </div>   
    </br>
    <div id='adminDashVolunteer'>
    	<label>test</label>
    	<?php if (isset($volunteerGrid)) echo $volunteerGrid; ?>
    </div>   
</div>
