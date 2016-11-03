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

if(!property_exists($raw_data, 'amount')){
  echo validation_error("Amount can't be empty");
  die();
}

if(empty($raw_data->amount)){
  echo validation_error("Amount can't be empty");
  die();
}

if(!property_exists($raw_data,  'pay_type')){
  echo validation_error("Payment type can't be empty");
  die();
}

if(!property_exists($raw_data, 'bank_name')){
  $raw_data->bank_name = NULL;
}

if(!property_exists($raw_data, 'reference')){
  $raw_data->reference = NULL;
}


echo json_encode($master_payments->add($raw_data));



 ?>
