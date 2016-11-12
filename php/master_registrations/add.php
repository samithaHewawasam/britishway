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

$master_registrations = new master_registrations();

if(!property_exists($raw_data, 'course_id')){
  echo validation_error("Course can't be empty");
  die();
}

if(!property_exists($raw_data, 'reg_no')){
  echo validation_error("Reg No can't be empty");
  die();
}

if(!property_exists($raw_data, 'reg_date')){
  echo validation_error("Registration date can't be empty");
  die();
}

if(!DateTime::createFromFormat('Y-m-d', $raw_data->reg_date) !== FALSE){
  echo validation_error("Registration date is invalid");
  die();
}

if(!property_exists($raw_data, 'batch_id')){
  $raw_data->batch_id = NULL;
}

if(!property_exists($raw_data, 'student_master_id')){
  echo validation_error("Student ID can't be empty");
  die();
}

if(!property_exists($raw_data,  'fee_id')){
  echo validation_error("Fee Structure can't be empty");
  die();
}

if(!property_exists($raw_data,  'fee')){
  echo validation_error("Gross can't be empty");
  die();
}

if(!property_exists($raw_data,  'reg_fee')){
  $raw_data->reg_fee = NULL;
}

if(!property_exists($raw_data,  'discount')){
  $raw_data->discount = 0;
}

if(!property_exists($raw_data,  'discount_comment')){
  $raw_data->discount_comment = NULL;
}

if(property_exists($raw_data,  'fee')){
  $raw_data->net = $raw_data->fee - $raw_data->discount;
}


if(property_exists($raw_data,  'fee_installments') && $raw_data->discount > 0){

  foreach(array_reverse($raw_data->fee_installments, true) as $key => &$fee_installment){

    if($fee_installment->amount > $raw_data->discount){
      $fee_installment->amount -= $raw_data->discount;
      break;
    }else if($fee_installment->amount <= $raw_data->discount){
      $raw_data->discount -= $fee_installment->amount;
      unset($raw_data->fee_installments[$key]);
    }

  }

}

echo json_encode($master_registrations->add($raw_data));



 ?>
