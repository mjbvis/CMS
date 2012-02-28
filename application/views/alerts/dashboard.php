Welcome,

you must resolve the following alerts:</br>
<ul>
<? 
    foreach($userAlerts->result_array() as $alert){
?>
        <li> <? echo  $alert['Description'] . '</br>'; ?> </li>
<?
    }   
?>
</ul>