<?php

    if(empty($_FILES)){
        $fsz=0;
    }else{
       $fsz = 1;   
       $fff=str_replace("C:\\fakepath\\","",$_POST['fakefilefield']);
    }
    
?>
