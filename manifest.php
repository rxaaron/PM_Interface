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
        $this->Ln(5);
    }
    
    function Footer(){
        $sigline = str_pad("Sign/Print Name",75,"_")."  ".str_pad("Date",25,"_");
        $this->SetY(-25);
        $this->SetFont('Times','',11);
        $this->Cell(0,15,$sigline,0,1,'L');
        $this->SetFont('Times','',12);
        $datepage = date("F j, Y")."  Page ".$this->PageNo()." of {nb}";
        $this->Cell(0,0,$datepage,0,0,'R');
    }
}

$pdf = new myPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',14);
$pdf->Cell(0,0,"Go baby Go!!!",0,0,'R');
$pdf->Output();

?>