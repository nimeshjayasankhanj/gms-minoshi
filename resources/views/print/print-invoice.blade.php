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

$pdf->Cell($width,$height/1.5,'SUN STAR HOLDINGS','0',1,'C');

$pdf->SetFont('Arial','',7);//set font to arial, regular, 8pt

$pdf->Cell($width,$height/1.5,'No 566/7/A,Aldeniya,Kadawatha,','0',1,'C');
$pdf->Cell($width,$height/1.5,'Sri Lanka','0',1,'C');


$pdf->Cell($width,$height/1.5,'Tel: 0768552644','0',1,'C');//end of line

$pdf->Cell($width,$height/10,'','0',1,'C');//Horizontal Line

$pdf->SetFont('Arial','B',7);
$pdf->Cell($width,$height,'Customer :','0',1,'L');
$pdf->SetFont('Arial','',7);

$customer=\App\User::find($invoice->customer);

$pdf->Cell($width,$height,$customer->first_name.' '.$customer->last_name,'0',1,'L');

$pdf->SetFont('Arial','B',7);
$pdf->Cell($width,$height,'Invoice No : '.str_pad($invoice->idinvoice,6,'0',STR_PAD_LEFT),'0',1,'L');
$pdf->SetFont('Arial','',7);

$pdf->Cell($width,3,'','T',1,'C');//Horizontal Space

$items=\App\ItemInvReg::where('invoice_idinvoice', $invoice->idinvoice)->orderBy('created_at', 'desc')->where('status', 1)->get();

foreach ($items as $item) {
    $x=1;
   $pdf->SetFont('Arial','',6);//set font to arial, Bold, 10pt
   
   $pdf->Cell($width/3,3,$x.') '.$item->Product->product_name,'0',0,'L');
   $pdf->Cell($width/3,3,$item->qty.' Qty','0',0,'L');
 
   $pdf->Cell($width/3,4,number_format($item->Product->selling_price*$item->qty,2),'0',1,'R');
   $x++;
}

$pdf->Cell($width,$height,'','T',1,'C');//Horizontal Space



$pdf->SetFont('Arial','B',6);//set font to arial, Bold, 10pt
$totalCost=\App\MasterBooking::find($invoice->master_booking_idmaster_booking);
$pdf->Cell($width/2,3,'Total Amount','0',0,'L');
$pdf->Cell($width/2,4,number_format($totalCost->total,2),'0',1,'R');



$pdf->Cell($width,$height/2,'','0',1,'T');//Horizontal space
$pdf->SetFont('Arial','',6);//set font to arial, Bold, 10pt
$pdf->Cell($width,$height,'Thank You!','0',1,'C');
//output the result
//$pdf->AutoPrint();
$pdf->Output();
exit();
?>