<?php

include __DIR__ . '/autoload.php';
$rawData = file_get_contents("php://input");
$POST = json_decode($rawData);

$add = new add();

if(!empty($POST->ati_name)){

  echo json_encode($add->setAtis(array(array(
      'query' => "INSERT INTO `ati`(`ati_name`) VALUES (?)",
      'data' => array($POST->ati_name)
  ))));

}else if(!empty($POST->course_code) && !empty($POST->course_name)){

  echo json_encode($add->setCourses(array(array(
      'query' => "INSERT INTO `courses`(`course_code`, `course_name`) VALUES (?, ?)",
      'data' => array($POST->course_code, $POST->course_name)
  ))));

}else if(!empty($POST->subject_code) && !empty($POST->subject_name) && !empty($POST->course)){

  echo json_encode($add->setSubjects(array(array(
      'query' => "INSERT INTO `subjects`(`subject_code`, `subject_name`, `course`, `status`) VALUES (?, ?, ?, ?)",
      'data' => array($POST->subject_code, $POST->subject_name, $POST->course, 1)
  ))));

}else if(!empty($POST->Course) && !empty($POST->Ati)){

  echo json_encode($add->setCourseToAti(array(array(
      'query' => "INSERT INTO `ati_courses`(`course_id`, `ati_id`) VALUES (?, ?)",
      'data' => array($POST->Course, $POST->Ati)
  ))));

}


?>
