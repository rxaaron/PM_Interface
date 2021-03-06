<?php
    session_start();
    include_once('dbconn.php');
    
    $ssselect=$db->query("SELECT A.Rx_Number, A.Patient_Name, A.Patient_Group, B.Drug_Name, A.Rx_Stop_Date, A.Rx_Start_Date FROM ".$_SESSION['prefix']."_Rx AS A INNER JOIN Drug AS B ON A.Drug_Code = B.Drug_Code WHERE (A.Rx_Stop_Date BETWEEN ".date("Ymd",strtotime($_POST['start']))." AND ".date("Ymd",strtotime($_POST['stop'])).") OR (A.Rx_Start_Date BETWEEN ".date("Ymd",strtotime($_POST['start']))." AND ".date("Ymd",strtotime($_POST['stop'])).");");
    
    $tablestart = "<table class=\"table table-striped\"><thead><tr><th>Rx Number</th><th>Drug</th><th>Start Date</th><th>Stop Date</th></tr></thead><tbody>";
    $tableend = "</tbody></table>";
    $pname = "";
    $first=true;
    while($ssrez=$ssselect->fetch_object()){
        if($pname===$ssrez->Patient_Name){
            echo "<tr><td>".$ssrez->Rx_Number."</td><td>".$ssrez->Drug_Name."</td><td>".date("m/d/Y",strtotime($ssrez->Rx_Start_Date))."</td><td>".date("m/d/Y",strtotime($ssrez->Rx_Stop_Date))."</td></tr>";
        }else{
            if(!$first){
                echo $tableend;
            }
            $pname=$ssrez->Patient_Name;
            echo "<h3><code>".$ssrez->Patient_Group."</code> ".$pname."</h3>";    
            echo $tablestart;
            echo "<tr><td>".$ssrez->Rx_Number."</td><td>".$ssrez->Drug_Name."</td><td>".date("m/d/Y",strtotime($ssrez->Rx_Start_Date))."</td><td>".date("m/d/Y",strtotime($ssrez->Rx_Stop_Date))."</td></tr>";
            $first=false;
        }
    }
?>
