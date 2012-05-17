<form name="form" method="POST">

    <label>Menu Item ID</label>
    <?php echo form_error(''); ?>
    <input type="text" name="menuItemID" value="<?php echo set_value('menuItemID');?>" /><br />
    <br />
    
    <label>Label</label>
    <?php echo form_error(''); ?>
    <input type="text" name="label" value="<?php echo set_value('label');?>" /><br />
    <br />

    <label>URL</label>
    <?php echo form_error(''); ?>
    <input type="text" name="URL" value="<?php echo set_value('URL');?>" /><br />
    <br />

    <label>RankOrder</label>
    <?php echo form_error(''); ?>
    <input type="text" name="rankOrder" value="<?php echo set_value('rankOrder');?>" /><br />
    <br />

    <div id="bottom">
        <input type="submit" value="Submit" name="submit" class="submit"/>
    </div>
    
</form>