<?php
    
    session_start();
    include_once('dbconn.php');
    
    $hoa_rx=$db->query("SELECT A.Help_ID, A.Rx_Number, A.Drug_Name AS Drug_Code, B.Drug_Name, A.Patient_Name AS Patient_ID, C.Patient_Name, C.Patient_Group, A.Instructions, A.Doctor, A.RPh FROM ".$_SESSION['prefix']."_HOA AS A INNER JOIN Drug AS B ON A.Drug_Name = B.Drug_Code INNER JOIN Patient AS C ON A.Patient_Name = C.Patient_ID;");

    $tableend = "</tbody></table></form>";
     
    if($hoa_rx->num_rows!=0){
        
        while($results=$hoa_rx->fetch_object()){
            echo "<div id=\"div".$results->Rx_Number."\"><h3><code>".$results->Patient_Group."</code> ".$results->Patient_Name." ".$results->Rx_Number."</h3><h5>".$results->Drug_Name.": </h5><h6>".$results->Instructions."</h6><form id=\"f".$results->Rx_Number."\" autocomplete=\"off\" >";
            echo "<table id=\"t".$results->Rx_Number."\" class=\"table table-striped\"><thead><tr><th>Admin Date</th><th>Admin Time</th><th>Quantity</th></tr></thead><tbody>";
            echo "<tr><td><div class=\"input-append date datepicker\" data-date-format=\"mm/dd/yyyy\"><input class=\"input-small\" type=\"text\" id=\"admindate\" autocomplete=\"off\" name=\"admindate[]\"><span class=\"add-on\"><i class=\"icon-calendar\"></i></span></div></td><td><div class=\"input-append pad4\"><input id=\"admintime\" class=\"input-small\" type=\"text\" autocomplete=\"off\" name=\"admintime[]\"><span class=\"add-on\"><i class=\"icon-time\"></i></span></div></td><td><div class=\"input-append pad4\"><input type=\"text\" class=\"input-small\" name=\"quantity[]\"><span class=\"add-on\"><strong>#</strong></span></div></td><td><div class=\"pad4\"><button class=\"btn btn-primary btn-mini\" type=\"button\" onClick=\"newRow('t".$results->Rx_Number."');\"><i class=\"icon-plus\"></i></button></div></td></tr>";
            echo $tableend;
            echo "<button class=\"btn btn-success\" type=\"button\" onclick=\"saveRx('".$results->Patient_ID."','".$results->Drug_Code."','".$results->Doctor."','".$results->Rx_Number."','".$results->Instructions."','".$results->RPh."');\">Save</button></div>";
        }
    }

?>
