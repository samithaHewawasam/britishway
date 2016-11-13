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

$master_students = new master_students();

if(!property_exists($raw_data, 'student_id')){
  echo validation_error("Student ID can't be empty");
  die();
}

echo json_encode($master_students->edit_data($raw_data->student_id));



 ?>
