<?php
    include_once('dbconn.php');
    
    if(!$db){
        exit("Could not connect to database.");
    }else{
        $clear_tables=$db->query("DELETE FROM HOA_Time");
        
        if ($clear_tables){
            $select1= $db->query("SELECT HOA_ID AS HOACode, Time1, Time2, Time3, Time4, Time5, Time6, Time7, Time8, Time9, Time10, Time11, Time12 FROM HOA;");
            if($select1){
                if($select1->num_rows!=0){
                    $sth1 = $dbh->prepare("INSERT INTO HOA_Time (HOA_ID,Admin_Time) VALUES (:code,:time);");
                    
                    while($res1=$select1->fetch_object()){
                        if(($ts = strtotime($res1->Time1))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time2))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time3))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time4))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time5))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time6))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time7))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time8))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time9))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time10))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time11))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                        if(($ts = strtotime($res1->Time12))!=false){
                            $sth1->execute(array(':code'=>$res1->HOACode, ':time'=>date("H:i",$ts)));
                        }
                    }
                }else{
                    echo "No rows?";
                }
            }
        }
    }
    
?>
