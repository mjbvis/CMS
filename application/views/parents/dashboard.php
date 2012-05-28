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
			<h3>Notifications</h3>
			<IFRAME SRC=<?php echo base_url('parents/notificationGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
			<h3><a href="<?php echo base_url('parents/manageMyVolunteerActivity'); ?>">Volunteer Log</a></h3>
			<IFRAME SRC=<?php echo base_url('parents/volunteeringGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
		<td valign="top" width="400">
			<h3><a href="<?php echo base_url('admissions/waitlistQuestionaire'); ?>">Waitlisted</a></h3>
			<IFRAME SRC=<?php echo base_url('parents/waitlistGrid');?>  class="autoHeight" frameborder="0"></IFRAME>
			<h3><a href="<?php echo base_url('admissions/registerStudentSelector'); ?>">Pre-Enrolled</a></h3>
			<IFRAME SRC=<?php echo base_url('parents/preEnrolledGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
			<h3><a href="<?php echo base_url('parents/manageMyStudents'); ?>">Registered</a></h3>
			<IFRAME SRC=<?php echo base_url('parents/registeredGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
</table>