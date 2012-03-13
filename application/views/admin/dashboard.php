This is the default admin dashboard view

<ul>
	<?php foreach($MenuItems as $mItem): ?>
	    	<? $attributes = $mItem->attributes(); ?>
	        <li> <? echo  $attributes['label'] . '</br>'; ?> </li>
	<?php endforeach; ?>
	</br>
	<?php foreach($MenuItems as $mItem): ?>
	    	<? $attributes = $mItem->attributes(); ?>
	        <li> <? echo  $attributes['label'] . '</br>'; ?> </li>
	<?php endforeach; ?>
</ul>