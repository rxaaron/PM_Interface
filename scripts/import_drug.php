<?php
    
$data[0] = str_replace("\\","",$data[0]);
$data[0] = str_replace("'","",$data[0]);
$data[1] = str_replace("\\","",$data[1]);
$data[1] = str_replace("'","",$data[1]);
$data[2] = str_replace("\\","",$data[2]);
$data[2] = str_replace("'","",$data[2]);
$data[3] = str_replace("\\","",$data[3]);
$data[3] = str_replace("'","",$data[3]);
$data[4] = str_replace("\\","",$data[4]);
$data[4] = str_replace("'","",$data[4]);
$data[5] = str_replace("\\","",$data[5]);
$data[5] = str_replace("'","",$data[5]);
$data[6] = str_replace("\\","",$data[6]);
$data[6] = str_replace("'","",$data[6]);
$data[7] = str_replace("\\","",$data[7]);
$data[7] = str_replace("'","",$data[7]);
$data[8] = str_replace("\\","",$data[8]);
$data[8] = str_replace("'","",$data[8]);
$data[9] = str_replace("\\","",$data[9]);
$data[9] = str_replace("'","",$data[9]);
$data[10] = str_replace("\\","",$data[10]);
$data[10] = str_replace("'","",$data[10]);
$data[11] = str_replace("\\","",$data[11]);
$data[11] = str_replace("'","",$data[11]);


        $insrt=$db->query("INSERT INTO Drug (NDC,Drug_Name,Drug_Strength,Drug_Type,Drug_Class,Drug_Code,Generic_Description,Generic_Indicator,Manufacturer,NH_Therapeutic_Class,Obsolete_Drug,Drug_Category) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."');");

    
?>
