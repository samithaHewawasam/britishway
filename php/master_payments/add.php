<?php
include __DIR__ . '/../autoload.php';
$raw_data = json_decode(file_get_contents("php://input"));
$response = array('commit' => false, 'error' => null, 'error_alert' => null, 'rollback' => false);
function validation_error($error){

  if(!empty($error)){
    $response['commit'] = false;
    $response['rollback'] = true;
    $response['error_alert'] = $error;
    return json_encode($response);
  }
}

$master_payments = new master_payments();
$multiplePaymentsArray = array();

if(!property_exists($raw_data, 'master_reg_no')){
  echo validation_error("Reg No can't be empty");
  die();
}

if(property_exists($raw_data, 'master_reg_no')){
  if(strlen($raw_data->master_reg_no) != 11){
    echo validation_error("Reg No is invalid");
    die();
  }
}

if(!property_exists($raw_data, 'pay_date')){
  echo validation_error("Payment date can't be empty");
  die();
}

if(!DateTime::createFromFormat('Y-m-d', $raw_data->pay_date) !== FALSE){
  echo validation_error("Payment date is invalid");
  die();
}

if(!property_exists($raw_data, 'receipt')){
  echo validation_error("Receipt can't be empty");
  die();
}

if(!property_exists($raw_data, 'cash_amount') && !property_exists($raw_data, 'cheque_amount') && !property_exists($raw_data, 'credit_amount') && !property_exists($raw_data, 'bank_amount')){
  echo validation_error("Amount can't be empty");
  die();
}

if($raw_data->cash_amount <= 0 && $raw_data->cheque_amount <= 0 && $raw_data->credit_amount <= 0 && $raw_data->bank_amount <= 0){
  echo validation_error("Amount is Invalid");
  die();
}

$multiplePaymentsArray['Cash'] = array();
$multiplePaymentsArray['Cheque'] = array();
$multiplePaymentsArray['Credit'] = array();
$multiplePaymentsArray['Bank'] = array();

$multiplePaymentsArray['Cash']['amount'] = $raw_data->cash_amount;
$multiplePaymentsArray['Cheque']['amount'] = $raw_data->cheque_amount;
$multiplePaymentsArray['Credit']['amount'] = $raw_data->credit_amount;
$multiplePaymentsArray['Bank']['amount'] = $raw_data->bank_amount;


$multiplePaymentsArray['Cheque']['bank_name'] = $raw_data->cheque_bank_name;
$multiplePaymentsArray['Cheque']['reference'] = $raw_data->cheque_reference;

$multiplePaymentsArray['Credit']['bank_name'] = $raw_data->credit_bank_name;
$multiplePaymentsArray['Credit']['reference'] = $raw_data->credit_reference;

$multiplePaymentsArray['Bank']['bank_name'] = $raw_data->diposits_bank_name;
$multiplePaymentsArray['Bank']['reference'] = $raw_data->diposits_reference;

$raw_data->pay_type_array = $multiplePaymentsArray;
$response_data = array();
$response_data = $master_payments->add($raw_data);
$_SESSION['receipt'] = new stdClass;
$_SESSION['receipt'] = $response_data['data'][0];
$_SESSION['receipt']->name = $raw_data->name_initials;
$_SESSION['receipt']->course_name = $raw_data->course_name;
echo json_encode($response_data);



 ?>
