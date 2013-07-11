<?php
    
    session_start();
    include_once('dbconn.php');
    
    $slctexp=$db->query("SELECT DISTINCT A.Rx_Number, B.Patient_Name, B.Patient_Group, C.Drug_Name, A.Admin_Time, SUM(A.Quantity) AS SUM FROM ".$_SESSION['prefix']."_Export AS A INNER JOIN Patient AS B ON A.Patient_ID = B.Patient_ID INNER JOIN Drug AS C ON A.Drug_Code = C.Drug_Code GROUP BY A.Rx_Number, B.Patient_Name, C.Drug_Name, A.Admin_Time");
    
    $tablestart = "<table class=\"table table-striped\"><thead><tr><th>Rx Number</th><th>Drug</th><th>Time</th><th>Quantity</th></tr></thead><tbody>";
    $tableend = "</tbody></table>";
    $pname="";
    $first=true;
    while($expres=$slctexp->fetch_object()){
        if($pname===$expres->Patient_Name){
            echo "<tr><td><button class=\"btn btn-primary btn-mini\" onClick=\"removeexport('".$expres->Rx_Number."','".$expres->Admin_Time."','".$pname."','".$expres->Drug_Name."');\" >".$expres->Rx_Number."</button></td><td>".$expres->Drug_Name."</td><td>".date("H:i",strtotime($expres->Admin_Time))."</td><td>".$expres->SUM."</td></tr>";
        }else{
            if(!$first){
                echo $tableend;
            }
            $pname=$expres->Patient_Name;
            echo "<h3><code>".$expres->Patient_Group."</code> ".$pname."</h3>";
            echo $tablestart;
            echo "<tr><td><button class=\"btn btn-primary btn-mini\" onClick=\"removeexport('".$expres->Rx_Number."','".$expres->Admin_Time."','".$pname."','".$expres->Drug_Name."');\" >".$expres->Rx_Number."</button></td><td>".$expres->Drug_Name."</td><td>".date("H:i",strtotime($expres->Admin_Time))."</td><td>".$expres->SUM."</td></tr>";
            $first=false;
        }
        
    }
    
    
?>
