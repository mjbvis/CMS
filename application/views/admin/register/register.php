<div class="formBox">
		<form method="post" id="registerUser" class="clearfix">
		    <fieldset>
		    <legend><h2>Register a new parent account</h2></legend>
		    <ul>
		    	<li>
					<label>First Name:</label>
					<input type="text" name="first" size="50" class="form" value="<?php echo set_value('first'); ?>" /><br /><?php echo form_error('first'); ?><br />
				</li>
				<li>
					<label>Middle Name:</label>
					<input type="text" name="middle" size="50" class="form" value="<?php echo set_value('middle'); ?>" /><br /><?php echo form_error('middle'); ?><br />
				</li>
				<li>
					<label>Last Name:</label>
					<input type="text" name="last" size="50" class="form" value="<?php echo set_value('last'); ?>" /><br /><?php echo form_error('last'); ?><br />
				</li>
				<li>
					<label>Email:</label>
					<input type="text" name="email" size="50" class="form" value="<?php echo set_value('email'); ?>" /><?php echo form_error('email'); ?><br /><br />
				</li>
				<li>
					<label>Address:</label>
					<input type="text" name="pOneAddressName" id="pOneAddressId" max="100" placeholder="Address" /> </br>
				</li>
				<li>
					<label>Home Phone:</label>
					<input type="text" name="pOneHomePhoneName" id="pOneHomePhoneId" max="15" placeholder="555-555-5555" /> </br>
				</li>
				<li>
					<label>Cell Phone:</label>
					<input type="text" name="pOneCellPhoneName" id="pOneCellPhoneId" max="15" placeholder="555-555-5555"  /> </br>
				</li>
				<li>
					<label>Business Phone:</label>
					<input type="text" name="pOneBusinessPhoneName" id="pOneBusinessPhoneId" max="15" placeholder="555-555-5555"  /> </br>
				</li>
				<li>
					<label>Employer:</label>
					<input type="text" name="pOneEmployerName" id="pOneEmployerId" max="100" placeholder="Employer Name"  /> </br>
				</li>
				<li>
					<label>Occupation:</label>
					<input type="text" name="pOneOccupationName" id="pOneOccupationId" max="100" placeholder="Occupation"  /> </br>
				</li>
			</ul>
			</fieldset>
		
		<input type="submit" value="Register" name="register" class="submit"/>
	</form>
</div>