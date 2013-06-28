<?php

    if(empty($_FILES)){
        $fsz=0;
        
    }else{
       $fsz = 1;   
       $ff=str_replace("C:\\fakepath\\","",$_POST['fakefilefield']);

      $file = $_FILES['file2import'][tmp_name]; 
    $handle = fopen($file,"r"); 
       
       $firstrow=true;
       $table_id="";
       $script="";
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
                           
                       }
                       
                   }
                   
               }else{
                   include($script);

               }
               
           }
       }while ($data = fgetcsv($handle,1000,","));
    
       $updateimport=$db->query("UPDATE Import SET UpdateTime='".date("m/d/y h:i a")."' WHERE Table_ID=".$table_id.";");
    }
    
?>
