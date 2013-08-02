<?php
   
    session_start();
    include_once('dbconn.php');
    
    If (!isset($_POST['page'])){
        $curpage = 1;
    }else{
        $curpage = $_POST['page'];
    }
    $splitfactor = 10;
    $startpoint = ($curpage * $splitfactor)-$splitfactor;
    
    $counthistory = $db->query("SELECT A.Batch_Name, B.Visible_Name, A.Batch_Date, C.Patient_Group, COUNT(DISTINCT A.Rx_Number) AS Rx_Count FROM Batch_History AS A INNER JOIN Computer AS B ON A.Batch_Creator = B.Computer_ID INNER JOIN Patient AS C ON A.Patient_ID = C.Patient_ID GROUP BY A.Batch_Name, A.Batch_Date, C.Patient_Group");
    
    $fullhistory=$db->query("SELECT A.History_ID, A.Batch_Name, B.Visible_Name, A.Batch_Date, C.Patient_Group, COUNT(DISTINCT A.Rx_Number) AS Rx_Count FROM Batch_History AS A INNER JOIN Computer AS B ON A.Batch_Creator = B.Computer_ID INNER JOIN Patient AS C ON A.Patient_ID = C.Patient_ID GROUP BY A.Batch_Name, A.Batch_Date, C.Patient_Group LIMIT ".$startpoint.",".$splitfactor);
    // GROUP BY A.Batch_Name, A.Batch_Date, C.Patient_Group
    
    $startlines = "<div class=\"pagination\"><ul>";
    $endlines = "</ul></div>";
    $totalrows = $counthistory->num_rows;
    $totalpages = $totalrows / $splitfactor;
    $totalpages = ceil($totalpages);

    echo $startlines;

    if($totalpages<5){
        //list all pages, no prev/next
        $i=1;
        do{
            if($i==$curpage){
                echo"<li class=\"active\"><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }else{
                echo"<li><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }
            $i++;
        }while($i<=$totalpages);
    }elseif($curpage==1){
        //1st page disables previous
        $i=1;
        echo"<li class=\"disabled\"><span>&laquo;</span></li>";
                do{
            if($i==$curpage){
                echo"<li class=\"active\"><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }else{
                echo"<li><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }
            $i++;
        }while($i<=5);
        echo"<li><a href=\"#\" onclick=\"refreshalltime(".($curpage+1).");\">&raquo;</a></li>";
    }elseif($curpage==$totalpages){
        //last page disables next
                $i=$totalpages-4;
        echo"<li><a href=\"#\" onclick=\"refreshalltime(".($curpage-1).");\">&laquo;</a></li>";
                do{
            if($i==$curpage){
                echo"<li class=\"active\"><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }else{
                echo"<li><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }
            $i++;
        }while($i<=$totalpages);
        echo"<li class=\"disabled\"><span>&raquo;</span></li>";
    }elseif($curpage<4){
        //keep aligned to 1
               $i=1;
        echo"<li><a href=\"#\" onclick=\"refreshalltime(".($curpage-1).");\">&laquo;</a></li>";
                do{
            if($i==$curpage){
                echo"<li class=\"active\"><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }else{
                echo"<li><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }
            $i++;
        }while($i<=5);
        echo"<li><a href=\"#\" onclick=\"refreshalltime(".($curpage+1).");\">&raquo;</a></li>";
        
    }elseif($curpage>($totalpages-3)){
        //keep aligned to end
        $i=$totalpages-4;
        echo"<li><a href=\"#\" onclick=\"refreshalltime(".($curpage-1).");\">&laquo;</a></li>";
                do{
            if($i==$curpage){
                echo"<li class=\"active\"><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }else{
                echo"<li><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }
            $i++;
        }while($i<=$totalpages);
        echo"<li><a href=\"#\" onclick=\"refreshalltime(".($curpage+1).");\">&raquo;</a></li>";
    }else{
        //two in front, two behind
                //keep aligned to end
        $i=$curpage-2;
        echo"<li><a href=\"#\" onclick=\"refreshalltime(".($curpage-1).");\">&laquo;</a></li>";
                do{
            if($i==$curpage){
                echo"<li class=\"active\"><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }else{
                echo"<li><a href=\"#\" onclick=\"refreshalltime(".$i.");\">".$i."</a></li>";
            }
            $i++;
        }while($i<=($curpage+2));
        echo"<li><a href=\"#\" onclick=\"refreshalltime(".($curpage+1).");\">&raquo;</a></li>";
    }
    
    echo $endlines;
    
    while($fhres=$fullhistory->fetch_object()){
        echo $fhres->History_ID." | ".$fhres->Batch_Name." | ".$fhres->Visible_Name." | ".date("m/d/Y",$fhres->Batch_Date)." | ".$fhres->Patient_Group."<br>";
    }
?>