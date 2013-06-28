<?php

include_once('dbconn.php');

if (!$db){
    exit ("There was a problem with the database.");
}else{
    
    $select=$db->query("SELECT Table_Name, UpdateTime FROM Import;");
    
    if($select){
        echo "<table class=\"table table-striped\">";
        echo "<thead><tr><th>File Name</th><th>Last Update Time</th></tr></thead>";
        echo "<tbody>";
        while($results=$select->fetch_object()){
            echo "<tr><td>".$results->Table_Name."</td><td>".$results->UpdateTime."</td></tr>";
        }
        echo "</tbody></table>";
    }
}
?>
