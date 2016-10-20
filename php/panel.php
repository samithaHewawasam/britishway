<?php
include __DIR__ . '/autoload.php';
$rawData = file_get_contents("php://input");
$POST = json_decode($rawData, true);
$add = new add();

if(!empty($POST)){

  echo json_encode($add->setAtis(array(array(
      'query' => "INSERT INTO `subject_panel`(`subject_id`, `panel_code`) VALUES (?,?)",
      'data' => array($POST->Subject, $POST->panel_code)
  ))));

}



?>
