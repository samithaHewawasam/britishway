<?php
include __DIR__ . '/../autoload.php';
include __DIR__ . '/../class/config.php';
include("../../vendor/autoload.php");

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' ';
    $dictionary  = array(
        0                   => '',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


$raw_data = $_SESSION['receipt'];
$pdf = new FPDF('L','mm',array(212,137));

$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 0);
$pdf->SetFont('Arial','B',10);
/* First 4 lines start*/
$pdf->SetY(39);
$pdf->SetX(11);
$pdf->Cell(50,7, BRANCH_NAME,0,0,'L');
$pdf->Cell(50,7, $raw_data->receipt,0,0,'L');
$pdf->Cell(50,7, $raw_data->pay_date,0,0,'L');
$pdf->Cell(50,7, $raw_data->reg_no,0,1,'L');
/* First 4 lines end */
/* Next 4 lines start */
$pdf->SetY(50);
$pdf->SetX(40);
$pdf->Cell(105,7, $raw_data->name,0,1,'L' );
$pdf->SetY(60);
$pdf->SetX(40);
$pdf->Cell(105,7, strtoupper(convert_number_to_words($raw_data->amount)).' ONLY',0,1,'L');
$pdf->SetY(70);
$pdf->SetX(40);
$pdf->Cell(105,7, $raw_data->course_name,0,1,'L');
$pdf->SetY(100);
$pdf->SetX(40);
$pdf->Cell(105,7, 3000,0,1,'L');
/* Bottom Lines start */
$pdf->setY(115);
$pdf->Cell(41,7, $raw_data->user_display_name,0,0,'L');
$pdf->setX(160);
$pdf->Cell(41,7,number_format($raw_data->amount,2)."/=",0,1,'L');
/* Bottom lines end */
$pdf->Output();



?>
