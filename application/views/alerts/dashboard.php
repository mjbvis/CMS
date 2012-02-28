Welcome USERNAME HERE,

you have the following alerts:</br>

<? 
    foreach($userAlerts->result_array() as $alert){
        echo  $alert['Description'] . '</br>';
    }
   
    
?>