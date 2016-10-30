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

$master_batches = new master_batches();

if(!property_exists($raw_data, 'batch_course_id')){
  echo validation_error("Course can't be empty");
  die();
}

if(!property_exists($raw_data, 'batch_code')){
  echo validation_error("Batch Code can't be empty");
  die();
}

if(!property_exists($raw_data, 'batch_commence')){
  echo validation_error("Commence date can't be empty");
  die();
}

if(!DateTime::createFromFormat('Y-m-d', $raw_data->batch_commence) !== FALSE){
  echo validation_error("Commence date is invalid");
  die();
}

if(!property_exists($raw_data, 'batch_end')){
  echo validation_error("End Date can't be empty");
  die();
}

if(!DateTime::createFromFormat('Y-m-d', $raw_data->batch_end) !== FALSE){
  echo validation_error("End Date is invalid");
  die();
}

if(!property_exists($raw_data, 'batch_intake')){
  $raw_data->batch_intake = NULL;
}

if(!property_exists($raw_data, 'id')){
  echo validation_error("This is invalid");
  die();
}
echo json_encode($master_batches->edit(
              $raw_data->id,
              $raw_data->batch_course_id,
              $raw_data->batch_code,
              $raw_data->batch_commence,
              $raw_data->batch_end,
              $raw_data->batch_intake
            ));

 ?>
