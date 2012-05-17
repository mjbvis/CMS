<script>
var counter = 1;
var limit = 3;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "Entry " + (counter + 1) + " <br><input type='text' name='myInputs[]'>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }

}
</script>

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
					<label>Last Name:</label>
					<input type="text" name="last" size="50" class="form" value="<?php echo set_value('last'); ?>" /><br /><?php echo form_error('last'); ?><br />
				</li>
				<li>
					<label>Email:</label>
					<input type="text" name="email" size="50" class="form" value="<?php echo set_value('email'); ?>" /><?php echo form_error('email'); ?><br /><br />
				</li>
			</ul>

		<input type="submit" value="Register" name="addParentUserAccount" class="submit"/>
	</form>
</div>