<?php
    session_start();
    //initialize all the good stuff.  $db is mysqli, $dbh is DBO.
    include_once('dbconn.php');
    
    
    //check for User Prefix variable. $_SERVER['REMOTE_ADDR'];
    if(!isset($_SESSION["prefix"])){
        $user_ip=$_SERVER["REMOTE_ADDR"];
        $olduser=$db->query("SELECT Prefix, Visible_Name, Computer_ID FROM Computer WHERE IP ='".$user_ip."';");
        if($olduser){
            if($olduser->num_rows!=0){
                //a returning user
                while($userinfo=$olduser->fetch_object()){
                   $_SESSION["prefix"]= $userinfo->Prefix;
                   $_SESSION["computer_name"]=$userinfo->Visible_Name;
                   $_SESSION["user_id"]=$userinfo->Computer_ID;
                }                    
             }else{
                 //never been here before.  needs new user specific tables and added to the user list.
                 $newprefix = "a".str_replace(".","",$user_ip);
                 $adduser=$db->query("INSERT INTO Computer (IP, Prefix, Visible_Name) VALUES ('".$user_ip."','".$newprefix."','".$newprefix."');");
                 if($adduser){
                     include('create_user_tables.php');
                     $_SESSION["prefix"]=$newprefix;
                     $_SESSION["computer_name"]=$newprefix;
                     $_SESSION["userid"]=$db->insert_id;
                 }
             }
        }
    }

?>