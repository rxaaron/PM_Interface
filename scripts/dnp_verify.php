<?php
   
    session_start();
    include_once('dbconn.php');
    
    $slctdrug = $db->query("SELECT Drug_Name, NDC FROM Drug WHERE Drug_ID = ".$_POST['drugid'].";");
    
    while($dres=$slctdrug->fetch_object()){
        $ndc0 = $dres->NDC;
        $ndc1 = substr_replace($ndc0, "-", 5,0);
        $ndc2 = substr_replace($ndc1,"-",-2,0);
        echo "<h2>".$dres->Drug_Name."</h2><h3>NDC: ".$ndc2."</h3><p>will be marked as Never Pack.</p>";
        echo "<button class=\"btn btn-success\" data-dismiss=\"modal\" aria-hidden=\"true\" id=\"godnpbtn\" onclick=\"markdrug(".$_POST['drugid'].",'".$dres->Drug_Name."');\" >Never Pack this Drug!</button>";
    }
    
?>