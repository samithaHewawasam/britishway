<?php
include __DIR__ . '/../autoload.php';
$raw_data = json_decode(file_get_contents("php://input"));

$master_students = new master_students();
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
