<style type="text/css">
	table, iframe{ width: 100%;	}
	table{
		text-align:center;
		border-collapse: collapse;
	}
</style>

<table border="0">
	<tr valign="top">
		<td colspan="2">
			<h3>Notifications</h3>
			<IFRAME SRC=<?php echo base_url('admin/notificationGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
	<tr>
		<td valign="top" width="400">
			<h3><a href="<?php echo base_url('admin/waitlist'); ?>">Waitlist</a></h3>
			<IFRAME SRC=<?php echo base_url('admin/waitlistGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
			<h3><a href="<?php echo base_url('admin/waitlist'); ?>">Pre-Enrolled List</a></h3>
			<IFRAME SRC=<?php echo base_url('admin/preEnrolledGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
		<td >
			<h3><a href="<?php echo base_url('admin/manageVolunteerLogs'); ?>">Recent Volunteer Activity</a></h3>
			<IFRAME SRC=<?php echo base_url('admin/volunteerLogGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
</table>

<table>
	<tr>
		<td width=100% valign="top">
			<h3><a href="<?php echo base_url('admin/prospectManagement'); ?>">Prospect Information</a></h3>
			<IFRAME SRC=<?php echo base_url('admin/prospectGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
</table>