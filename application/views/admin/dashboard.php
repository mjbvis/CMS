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
			<strong>Notifications</strong>
			<IFRAME SRC=<?php echo base_url('admin/notificationGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
	<tr>
		<td valign="top" width="400">
			<strong>Waitlist</strong>
			<IFRAME SRC=<?php echo base_url('admin/waitlistGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
			<strong>Pre-Enrolled List</strong>
			<IFRAME SRC=<?php echo base_url('admin/preEnrolledGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
		<td >
			<strong>Recent Volunteer Activity</strong>
			<IFRAME SRC=<?php echo base_url('admin/volunteerLogGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
</table>

<table>
	<tr>
		<td width=50% valign="top">
			<strong>Prospect Information</strong>
			<IFRAME SRC=<?php echo base_url('admin/volunteerLogGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
		
		<td width=50% valign="top">
			<strong>Recent Donation Activity</strong>
			<IFRAME SRC=<?php echo base_url('admin/volunteerLogGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
</table>