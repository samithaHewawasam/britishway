<?php

class master_students extends database
{

   public function add($student_id = "", $name_full  = "", $name_initials = "", $dob = "", $marital_status = "", $address = "", $contact_no_1 = "", $contact_no_2 = "", $email = "", $gender = "", $school_attended = "", $higher_qulification = "", $occupation = "", $place_of_work = "", $guardian_name = "", $guardian_contact_no = "", $find_by = "")
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
