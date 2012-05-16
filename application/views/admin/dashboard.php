<style type="text/css">
	table, iframe{ width: 100%;	}
	table{
		text-align:center;
		border-collapse: collapse;
	}
</style>
</br>
<table border="0">
	<tr>
		<td valign="top" width="400">
			Waitlist
			<IFRAME SRC=<?php echo base_url('admin/waitlistGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
			Pre-Enrolled List
			<IFRAME SRC=<?php echo base_url('admin/preEnrolledGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
		<td >
			Recent Volunteer Activity
			<IFRAME SRC=<?php echo base_url('admin/volunteerLogGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
</table>

<table>
	<tr>
		<td width=50% valign="top">
			Prospect Information
			<IFRAME SRC=<?php echo base_url('admin/volunteerLogGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
		
		<td width=50% valign="top">
			Recent Donation Activity
			<IFRAME SRC=<?php echo base_url('admin/volunteerLogGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
</table>
</br>