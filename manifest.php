<?php

require('fpdf/fpdf.php');
    
class myPDF extends FPDF {
    public $title = "Delivery Manifest";
    public $directions1 = "Please sign and date each manifest as the medications are checked in, then fax a copy to Encore Pharmacy at 304.647.9772";
    
    function Header(){
        $this->SetFont('Times','U',20);
        $this->Cell(0,9,$this->title,0,1,'C');
        $this->SetFont('Times','B',10);
        $this->Cell(0,7,$this->directions1,'B',1,'C');
        $this->Ln(1);
    }
    
    function Footer(){
        $sigline = str_pad("Sign/Print Name",75,"_")."  ".str_pad("Date",25,"_");
        $this->SetY(-20);
        $this->SetFont('Arial','',11);
        $this->Cell(0,15,$sigline,0,1,'L');
        $this->SetFont('Arial','',12);
        $pages ="Page ".$this->PageNo()." of {nb}";
        $this->Cell(25,0,"Delivery Date: ".date("F j, Y"),0,0,'L');
        $this->Cell(0,0,$pages,0,0,'R');
    }
}

include('scripts/dbconn.php');

$batch=$_GET['batch'];

$mfest=$db->query("SELECT A.Rx_Number, B.Patient_Name,B.Wing,B.Room,D.Facility_Name,E.Drug_Name,E.NDC,A.Admin_Time,SUM(A.Quantity) AS Qty, A.Admin_Date, COUNT(A.Admin_Date) AS NumDays FROM Daily_History AS A INNER JOIN Patient AS B ON A.Patient_ID=B.Patient_Id INNER JOIN FGroup AS C ON B.Patient_Group = C.Group_Name INNER JOIN Facility AS D ON C.Facility_ID = D.Facility_ID INNER JOIN Drug AS E ON A.Drug_Code = E.Drug_Code WHERE Batch_Date = '".$batch."' GROUP BY B.Patient_Name, E.NDC, A.Admin_Time ORDER BY B.Patient_Name, A.Admin_Time");

$pname = "";
$proom = "";
$curtime = "";

$pdf = new myPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetTopMargin(5);
$fontfam = "Arial";

while($rm=$mfest->fetch_object()){
    if($pname===$rm->Patient_Name){
        if($curtime===$rm->Admin_Time){
            $pdf->Cell(5,5,"",0,0,'L');
            $pdf->Cell(30,5,$rm->Rx_Number,0,0,'L');
            $pdf->Cell(35,5,$rm->NDC,0,0,'L');
            $pdf->Cell(75,5,$rm->Drug_Name,0,0,'L');
            $pdf->Cell(25,5,$rm->Qty,0,0,'C');
            $pdf->Cell(8,5,"",0,0,'L');
            $pdf->Cell(4,4,"",1,0,'C');
            $pdf->Ln(6); 
        }else{
            //Time header
            $curtime=$rm->Admin_Time;
            $pdf->SetFont($fontfam,'B',14);
            $pdf->Cell(25,6,date("h:i A",strtotime($rm->Admin_Time)),0,0,'L');
            $pdf->Ln(7);
            //first Rx
            $pdf->SetFont($fontfam,'',12);
            $pdf->Cell(5,5,"",0,0,'L');
            $pdf->Cell(30,5,$rm->Rx_Number,0,0,'L');
            $pdf->Cell(35,5,$rm->NDC,0,0,'L');
            $pdf->Cell(75,5,$rm->Drug_Name,0,0,'L');
            $pdf->Cell(25,5,$rm->Qty,0,0,'C');
            $pdf->Cell(8,5,"",0,0,'L');
            $pdf->Cell(4,4,"",1,0,'C');
            $pdf->Ln(6);
        }
    }else{
       $pname=$rm->Patient_Name;
       $proom=$rm->Wing.$rm->Room;
       $fname=$rm->Facility_Name;
       $firstday = date("m/d/Y",strtotime($rm->Admin_Date));
       $lastday = date("m/d/Y",strtotime($rm->Admin_Date." + ".$rm->NumDays." days"));
       $pdf->AddPage();
        //patient header
        $pdf->SetFont($fontfam,'',14);
        $pdf->Cell(23,6,"Resident:",0,0,'L');
        $pdf->SetFont($fontfam,'B',14);
        $pdf->Cell(75,6,$pname,0,0,'L');
        $pdf->SetFont($fontfam,'B',12);
        $pdf->Cell(25,6,$proom,0,0,'L');
        $pdf->SetFont($fontfam,'',14);
        $pdf->Cell(20,6,"Facility:",0,0,'L');
        $pdf->SetFont($fontfam,'B',14);
        $pdf->Cell(50,6,$fname,0,0,'L');
        $pdf->Ln(8);

        //Column labels
        $pdf->SetFont($fontfam,'',10);
        $pdf->Cell(5,5,"",0,0,'L');
        $pdf->Cell(30,5,"Rx Number",0,0,'L');
        $pdf->Cell(35,5,"NDC Number",0,0,'L');
        $pdf->Cell(75,5,"Drug Name",0,0,'C');
        $pdf->Cell(25,5,"Quantity",0,0,'C');
        $pdf->Cell(20,5,"Received",0,1,'C');
        $pdf->Cell(0,0,"",'B',0,'C');
        $pdf->Ln(2);
        $pdf->SetFont($fontfam,'',8);        
        $pdf->cell(0,4,"Administration Dates: ".$firstday." to ".$lastday,0,0,'R');
        $pdf->Ln(5);
        //Time header
        $curtime=$rm->Admin_Time;
        $pdf->SetFont($fontfam,'B',14);
        $pdf->Cell(25,6,date("h:i A",strtotime($rm->Admin_Time)),0,0,'L');
        $pdf->Ln(7);
        //first Rx
        $pdf->SetFont($fontfam,'',12);
        $pdf->Cell(5,5,"",0,0,'L');
        $pdf->Cell(30,5,$rm->Rx_Number,0,0,'L');
        $pdf->Cell(35,5,$rm->NDC,0,0,'L');
        $pdf->Cell(75,5,$rm->Drug_Name,0,0,'L');
        $pdf->Cell(25,5,$rm->Qty,0,0,'C');
        $pdf->Cell(8,5,"",0,0,'L');
        $pdf->Cell(4,4,"",1,0,'C');
        $pdf->Ln(6);
    }
}

$pdf->SetTitle(date("m-d-Y")." Manifest");
$pdf->SetCreator("Encore Pharmacy Solutions");
$pdf->SetAuthor("Computer Name");
$pdf->Output("Batch Name_".date("m-d-Y"),'I');

?>