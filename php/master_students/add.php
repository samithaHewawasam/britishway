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
if(!property_exists($raw_data, 'name_initials')){
  echo validation_error("Name with intials can't be empty");
  die();
}
if(!property_exists($raw_data, 'name_full')){
  $raw_data->name_full = NULL;
}
if(!property_exists($raw_data, 'dob')){
  $raw_data->dob = NULL;
}
if(!property_exists($raw_data, 'marital_status')){
  $raw_data->marital_status = NULL;
}
if(!property_exists($raw_data, 'address')){
  $raw_data->address = NULL;
}
if(!property_exists($raw_data, 'contact_no_1')){
  $raw_data->contact_no_1 = NULL;
}
if(!property_exists($raw_data, 'contact_no_2')){
  $raw_data->contact_no_2 = NULL;
}
if(!property_exists($raw_data, 'email')){
  $raw_data->email = NULL;
}
if(!property_exists($raw_data, 'gender')){
  $raw_data->gender = NULL;
}
if(!property_exists($raw_data, 'school_attended')){
  $raw_data->school_attended = NULL;
}
if(!property_exists($raw_data, 'higher_qulification')){
  $raw_data->higher_qulification = NULL;
}
if(!property_exists($raw_data, 'occupation')){
  $raw_data->occupation = NULL;
}
if(!property_exists($raw_data, 'place_of_work')){
  $raw_data->place_of_work = NULL;
}
if(!property_exists($raw_data, 'guardian_name')){
  $raw_data->guardian_name = NULL;
}
if(!property_exists($raw_data, 'guardian_contact_no')){
  $raw_data->guardian_contact_no = NULL;
}
if(!property_exists($raw_data, 'find_by')){
  $raw_data->find_by = NULL;
}
echo json_encode($master_students->add(
              $raw_data->student_id,
              $raw_data->name_full,
              $raw_data->name_initials,
              $raw_data->dob,
              $raw_data->marital_status,
              $raw_data->address,
              $raw_data->contact_no_1,
              $raw_data->contact_no_2,
              $raw_data->email,
              $raw_data->gender,
              $raw_data->school_attended,
              $raw_data->higher_qulification,
              $raw_data->occupation,
              $raw_data->place_of_work,
              $raw_data->guardian_name,
              $raw_data->guardian_contact_no,
              $raw_data->find_by
            ));

 ?>
