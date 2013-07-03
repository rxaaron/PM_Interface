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

        $insrt=$db->query("INSERT INTO Sig (Sig_Code,Sig_HOA,Line1,Line2,Line3,Line4,Line5,Line6,Line7,Line8) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."');");

?>
