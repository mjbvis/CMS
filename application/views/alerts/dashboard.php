Welcome USERNAME HERE,

you have the following alerts:

<? 
    while($row = mysql_fetch_array($alerts, MYSQL_ASSOC))
    {
        echo "Name :{$row['AlerID']} <br>";
    } 
?>