This is the default admin dashboard view

<ul>
<? 
    foreach($MenuItems as $mItem){
    	$attributes = $mItem->attributes();
?>
        <li> <? echo  $attributes['label'] . '</br>'; ?> </li>
<?
    }   
?>
</ul>