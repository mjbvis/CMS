<style type="text/css">
	table, iframe{ width: 100%;	}
	table{
		text-align:center;
		border-collapse: collapse;
	}
</style>

<table border="1">
	<tr>
		<td valign="top" width="300">
			<IFRAME SRC=<?php echo base_url('admin/waitlistGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
		<td valign="top">
			<IFRAME SRC=<?php echo base_url('admin/preEnrolledGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
			<IFRAME SRC=<?php echo base_url('admin/volunteerLogGrid'); ?> class="autoHeight" frameborder="0"></IFRAME>
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top"><IFRAME SRC=<?php echo base_url('admin/volunteerLogGrid'); ?> class="autoHeight" frameborder="0"></IFRAME></td>
	</tr>
</table>