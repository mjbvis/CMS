<div class="formBox">

	<?php
	/* display validation errors */
	$errors = validation_errors();
	if (!empty($errors)) {
		printf('<div class="validationBox">%s</div>', $errors);
	}
	?>

	<form id="editMenuItems" method="POST" accept-charset='UTF-8' class='clearfix'>
		<fieldset>
			<legend>Add New SubItem</legend>
			<ul>
				<li>
				    <label>Menu Item ID</label>
				    <?php
				    printf('<select name="MenuItemDropDown" >');
					foreach($allMenuItems as $miEntry):
						$miEntryAttr = $miEntry->attributes();
						printf('<option value="%d" %s >%s</option>', $miEntryAttr['menuitemid'], set_select('MenuItemDropDown', $miEntryAttr['menuitemid']), $miEntryAttr['label']);
					endforeach;
					printf('</select>');
					?>
				    <!--<input type="text" name="menuItemID" value="<?php echo set_value('menuItemID');?>" /><br />
			    	-->
			    </li>
				    <li>
				    </br>
				    <label>Label</label>
				    <input type="text" name="label" value="<?php echo set_value('label');?>" /><br />
				</li>
				<li>
				    <label>URL</label>
				    <input type="text" name="URL" value="<?php echo set_value('URL');?>" /><br />
				</li>
			    <li>
				    <label>RankOrder</label>
				    <input type="text" name="rankOrder" value="<?php echo set_value('rankOrder');?>" /><br />
			    </li>
			</ul>
		</fieldset>
 
        <input type="submit" value="Submit" name="submit" class="submit"/>
	</form>
</div>