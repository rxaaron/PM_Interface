<?php

    if(empty($_FILES)){
        $fsz=0;
        $fff=0;
     
    }else{
       $fsz = 1;   
       $ff=str_replace("C:\\fakepath\\","",$_POST['fakefilefield']);

      $file = $_FILES['file2import'][tmp_name]; 
      $handle = fopen($file,"r"); 
       
      $timechange=false;
       $firstrow=true;
       $table_id="";
       $script="";
       $rxtable=false;
       
       do{
          
           if($data[0]){
               
               if($firstrow){
                   $header="";
                   foreach($data as $da){
                       $header .=$da;
                       
                   }
                   $table=$db->query("SELECT Table_ID,Table_Name,Script FROM Import WHERE Header = '".$header."';");
                   if($table){
                       
                       while($tres=$table->fetch_object()){
                           $fff = $ff." was import as ".$tres->Table_Name." file.";
                           $script=$tres->Script;
                           $table_id=$tres->Table_ID;
                           $firstrow=false;
                           if($table_id==6){
                               $clear_sig=$db->query("TRUNCATE Sig;");
                           }
                           if($table_id==5){
                               $clear_rx=$db->query("TRUNCATE ".$_SESSION["prefix"]."_Rx;");
                           }
                           if($table_id==1){
                               $clear_drug=$db->query("TRUNCATE Drug;");
                           }
                       }
                       
                   }
                   
               }else{
                   include($script);

               }
               
           }
       }while ($data = fgetcsv($handle,1000,','));
    
       $updateimport=$db->query("UPDATE Import SET UpdateTime='".date("m/d/y h:i a")."' WHERE Table_ID=".$table_id.";");
       if($timechange){
         include_once('hoa_time_parser.php');  
       }
       if($rxtable){
           include_once('rx_hoa_work.php');
       }
       fclose($handle);
    }
    
?>
