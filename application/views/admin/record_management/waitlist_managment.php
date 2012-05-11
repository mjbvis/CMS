<!DOCTYPE html>

<html>
<head>

<script src="http://code.jquery.com/jquery-1.7.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>js/jquery.bbq.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.timepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/carbo.grid.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/carbo.form.js" type="text/javascript"></script>

</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/carbo/jquery-ui-1.8.16.custom.css" type="text/css" media="all" />
	<link href="<?php echo base_url(); ?>css/carbo.grid.css" rel="stylesheet" type="text/css" media="all" />
	<!--[if lt IE 7]><link href="<?php echo base_url(); ?>css/carbo.grid.ie6.css" rel="stylesheet" type="text/css" media="all" /><![endif]-->
	<link href="<?php echo base_url(); ?>css/carbo.form.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo base_url(); ?>css/960.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="content">
	<div class="container_12">
		<div class="grid_12">
			<?php echo form_open(); ?>
				<table width="100%">
				    <tr>
						<td style="vertical-align:top;"><?php echo $grid1; ?></td>
						<td style="text-align:center;">
							<input style="width:100px;" type="submit" name="moveToEnrolled" value="enroll>>" /><br/>
							<input style="width:100px;" type="submit" name="moveToWaitlist" value="<<waitlist" />
						</td>
						<td style="vertical-align:top;"><?php echo $grid2; ?></td>
					</tr>
				</table>
				<?php echo form_close(); ?>
			</div>
		<div class="clear"></div>
	</div>
</div>



</body>

</html>
