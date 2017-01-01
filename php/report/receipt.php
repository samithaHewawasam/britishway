<?php
include __DIR__ . '/../autoload.php';
include __DIR__ . '/../class/config.php';
include("../../vendor/autoload.php");

$raw_data = $_SESSION['receipt'];
$pdf = new FPDF('L','mm',array(212,137));

$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 0);
$pdf->SetFont('Arial','B',10);
/* First 4 lines start*/
$pdf->SetY(45);
$pdf->SetX(11);
$pdf->Cell(40,7, BRANCH_NAME,0,0,'L');
$pdf->Cell(40,7, $raw_data->receipt,0,0,'L');
$pdf->Cell(40,7, $raw_data->pay_date,0,0,'L');
$pdf->Cell(40,7, $raw_data->reg_no,0,1,'L');
/* First 4 lines end */
/* Next 4 lines start */
$pdf->Cell(105,7, $raw_data->receipt,0,1,'L' );
$pdf->Cell(105,7, $raw_data->receipt,0,1,'L');
$pdf->Cell(105,7, $raw_data->receipt,0,1,'L');
$pdf->Cell(105,7, $raw_data->receipt,0,1,'L');
/* Bottom Lines start */
$pdf->setY(120);
$pdf->Cell(41,7, $raw_data->user_display_name,0,0,'L');
$pdf->setX(92);
$pdf->Cell(41,7,number_format($raw_data->amount,2)."/=",0,1,'L');
/* Bottom lines end */
$pdf->Output();



?>
