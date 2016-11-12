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

if(!property_exists($raw_data, 'receipt_no')){
  echo validation_error("Receipt No can't be empty");
  die();
}

echo json_encode($master_payments->delete($raw_data->receipt_no));


 ?>
