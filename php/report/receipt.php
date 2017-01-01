<?php
include __DIR__ . '/../autoload.php';
include __DIR__ . '/../class/config.php';
include("../../vendor/autoload.php");

$raw_data = $_SESSION['receipt'];
$pdf = new FPDF('L','mm',array(212,137));

$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 0);
$pdf->SetFont('Arial','B',10);
/* First 4 lines */
$pdf->Cell(40,7, BRANCH_NAME,0,0,'L');
$pdf->Cell(40,7, $raw_data->receipt,0,0,'L');
$pdf->Cell(40,7, $raw_data->pay_date,0,0,'L');
$pdf->Cell(40,7, $raw_data->reg_no,0,1,'L');

$pdf->Cell(10,13, '',0,0,'L');
$pdf->Cell(100,13, $raw_data->receipt,0,1,'L' );
$pdf->Cell(1,8, '',0,0,'L');
$pdf->Cell(100,8, $raw_data->receipt,0,1,'L');
$pdf->Cell(14,10, '',0,0,'L');
$pdf->Cell(60,10, $raw_data->receipt,0,1,'L');
$pdf->Cell(20,9, '',0,0,'L');
$pdf->Cell(60,9, $raw_data->receipt,0,1,'L');
$pdf->Cell(100,4, '',0,1,'L');
$pdf->Cell(1,12, '',0,0,'L');
$pdf->Cell(60,12, $raw_data->user_display_name,0,0,'L');
$pdf->Cell(1,12, '',0,0,'L');
$pdf->Cell(30,12,number_format($raw_data->amount,2)."/=",0,1,'L');
$pdf->Output();



?>
