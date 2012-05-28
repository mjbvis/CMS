<style type="text/css">
	table, iframe{ width: 100%;	}
	table{
		text-align:center;
		border-collapse: collapse;
	}
</style>

<table border="0">
	<tr>
		<td valign="top">
			<strong>Notifications</strong>
			<IFRAME SRC=<?php echo base_url('parents/notificationGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
			<strong>Volunteer Logging</strong>
			<IFRAME SRC=<?php echo base_url('parents/volunteeringGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
		<td valign="top" width="400">
			<strong><a href="<?php echo base_url('admissions/waitlistQuestionaire'); ?>">Waitlisted</a></strong>
			<IFRAME SRC=<?php echo base_url('parents/waitlistGrid');?>  class="autoHeight" frameborder="0"></IFRAME>
			<strong><a href="<?php echo base_url('admissions/registerStudentSelector'); ?>">Pre-Enrolled</a></strong>
			<IFRAME SRC=<?php echo base_url('parents/preEnrolledGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
			<strong><a href="<?php echo base_url('parents/manageMyStudents'); ?>">Registered</a></strong>
			<IFRAME SRC=<?php echo base_url('parents/registeredGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
</table>