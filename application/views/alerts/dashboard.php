Welcome,

you must resolve the following alerts:</br>
<ul>
<?php 
    foreach($userAlerts->result_array() as $alert):
        printf('<li>%s</br></li>', $alert['Description']);
	endforeach;
?>
</ul>