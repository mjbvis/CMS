<style type="text/css">
	table, iframe{ width: 100%;	}
	table{
		text-align:center;
		border-collapse: collapse;
	}
</style>

<table border="0">
	<tr>
		<td>
			Notifications
			<IFRAME SRC=<?php echo base_url('parents/notificationGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
			Volunteer Logging
			<IFRAME SRC=<?php echo base_url('parents/volunteeringGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
		<td valign="top" width="400">
			Waitlisted
			<IFRAME SRC=<?php echo base_url('parents/waitlistGrid');?>  class="autoHeight" frameborder="0"></IFRAME>
			Pre-Enrolled
			<IFRAME SRC=<?php echo base_url('parents/preEnrolledGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
			Registered
			<IFRAME SRC=<?php echo base_url('parents/registeredGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
</table>

