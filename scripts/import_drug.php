<?php
    
    $slct=$db->query("SELECT Drug_ID FROM Drug WHERE Drug_Code='".$data[5]."';");
    
    if($slct->num_rows!=0){
        
        while($res=$slct->fetch_object()){
            $updt=$db->query("UPDATE Drug SET NDC='".$data[0]."',Drug_Name='".$data[1]."',Drug_Strength='".$data[2]."',Drug_Type='".$data[3]."',Drug_Class='".$data[4]."',Drug_Code='".$data[5]."',Generic_Description='".$data[6]."',Generic_Indicator='".$data[7]."',Manufacturer='".$data[8]."',NH_Therapeutic_Class='".$data[9]."',Obsolete_Drug='".$data[10]."',Drug_Category='".$data[11]."' WHERE Drug_ID=".$res->Drug_ID.";");
        }
    }else{
       
        $insrt=$db->query("INSERT INTO Drug (NDC,Drug_Name,Drug_Strength,Drug_Type,Drug_Class,Drug_Code,Generic_Description,Generic_Indicator,Manufacturer,NH_Therapeutic_Class,Obsolete_Drug,Drug_Category) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."');");
    }
    

?>
