<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/autoload.php';

$rawData = file_get_contents("php://input");
$POST = json_decode($rawData, true);
$add = new add();
if(!empty($POST)){

  echo json_encode($add->setAtis(array(array(
      'query' => "INSERT INTO `students_sat`(`institute`, `Course`, `Subject`, `packet`, `students_sat`, `students_absent`) VALUES (?,?,?,?,?,?)",
      'data' => array($POST['institute'], $POST['Course'], $POST["Subject"], $POST["packet"], $POST["students_sat"], $POST["students_absent"])
  ))));

}
?>
