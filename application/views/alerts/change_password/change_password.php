<div class="formBox">
        <form method="post" id="changePassword" class="clearfix">
            <fieldset>
            <legend><h2>Please Change your Password</h2></legend>
                Password: <input type="text" name="first" size="50" class="form" value="<?php echo set_value('password'); ?>" /><br /><?php echo form_error('password'); ?><br />
                Confirm Password: <input type="text" name="last" size="50" class="form" value="<?php echo set_value('password2'); ?>" /><br /><?php echo form_error('password2'); ?><br />
            </fieldset>
            <input type="submit" value="Change your Password" name="change" class="submit"/>
        </form>
</div>