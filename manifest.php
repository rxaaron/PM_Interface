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
        $datepage = date("F j, Y")."  Page ".$this->PageNo()." of {nb}";
        $this->Cell(0,0,$datepage,0,0,'R');
    }
}

$pdf = new myPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetTopMargin(5);
$fontfam = "Arial";

//loop by patient
$pname = "HONAKER, DOROTHY";
$fname = "Springfield Center";
$proom = "5505B";

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

//loop rxs by time

//time header
$pdf->SetFont($fontfam,'B',14);
$pdf->Cell(25,6,"08:00 AM",0,0,'L');
$pdf->Ln(7);

//list of rx's
$i = 0;
$pdf->SetFont($fontfam,'',12);
do{
    $pdf->Cell(5,5,"",0,0,'L');
    $pdf->Cell(30,5,"06047724",0,0,'L');
    $pdf->Cell(35,5,"00603002436",0,0,'L');
    $pdf->Cell(75,5,"SENTRY SENIOR MULTIV CAPL",0,0,'L');
    $pdf->Cell(25,5,"14",0,0,'C');
    $pdf->Cell(8,5,"",0,0,'L');
    $pdf->Cell(4,4,"",1,0,'C');
    $pdf->Ln(6);
    $i++;
}while($i<12);

$pdf->SetTitle(date("m-d-Y")." Manifest");
$pdf->SetCreator("Encore Pharmacy Solutions");
$pdf->SetAuthor("Computer Name");
$pdf->Output("Batch Name_".date("m-d-Y"),'I');

?>