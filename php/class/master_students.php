<?php

class master_students extends database
{

   public function add($student_id = NULL, $name_full  = NULL, $name_initials = NULL, $dob = NULL, $marital_status = NULL, $address = NULL, $contact_no_1 = NULL, $contact_no_2 = NULL, $email = NULL, $gender = NULL, $school_attended = NULL, $higher_qulification = NULL, $occupation = NULL, $place_of_work = NULL, $guardian_name = NULL, $guardian_contact_no = NULL, $find_by = NULL)
   {

       return parent::wrapper(array(
         array(
           'query' => "INSERT INTO `master_students`(`student_id`, `name_full`, `name_initials`, `dob`,
              `marital_status`, `address`, `contact_no_1`, `contact_no_2`, `email`, `gender`, `school_attended`,
              `higher_qulification`, `occupation`, `place_of_work`, `guardian_name`, `guardian_contact_no`, `find_by`)
              VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
           'data' => array(
             $student_id,
             $name_full,
             $name_initials,
             $dob,
             $marital_status,
             $address,
             $contact_no_1,
             $contact_no_2,
             $email,
             $gender,
             $school_attended,
             $higher_qulification,
             $occupation,
             $place_of_work,
             $guardian_name,
             $guardian_contact_no,
             $find_by
           )
       )));

   }

}


?>
