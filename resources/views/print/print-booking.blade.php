<?php
/**
 * Created by PhpStorm.
 * User: Harshadeva
 * Date: 7/31/2019
 * Time: 8:24 PM
 */
//call the FPDF library
require( base_path().'/public/pdf/fpdf.php');

$pdf = new FPDF();

//A4 size : 210x297mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm
$leftMargin = 0;
$rightMargin = 0;
$pageWidth = 50.8;
$width= $pageWidth-$rightMargin-$leftMargin;
$height = 5;
$pageHeight = 65;
$aditionalHeight = 0;
$separatorHeight = 5;

class Dash extends FPDF{
    function printDash($w,$h){
        for($i=0;$i< $w-2 ;$i = $i+2 ){
            $this->Cell(2,$h,'-','0',0,'L');
        }
        $this->Cell(2,$h,'-','',1,'L');
    }
}


//$regHeight = count($regs)*$height*2;
//foreach ($regs as $reg){
//
//    $lenght = strlen($reg->item->itemName);
//    $lines = $lenght/45;
//    if($lines>1){
//        $aditionalHeight += $lines*5;
//    }
//}

$actualHeight = $pageHeight+$aditionalHeight+$separatorHeight;
//create pdf object
//$pdf = new FPDF('P','mm',[$width,80+($noofitems*5)]);
$pdf = new Dash('P','mm',array($pageWidth,$actualHeight));
$pdf->SetMargins($leftMargin, 0 , $rightMargin);
$pdf->SetAutoPageBreak(true,0);

//add new page
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell($width,$height,'',0,1,'L');//Horizontal Space


$pdf-> Image('assets/images/barcode-png.png',1,1,48,25);

$pdf->SetFont('Arial','B',6);//set font to arial, Bold, 10pt


$pdf->Cell($width,45,$booking->barcode.'-'.$booking->User->first_name.''.$booking->User->last_name,'0',1,'L');



//output the result
//$pdf->AutoPrint();
$pdf->Output();
exit();
?>