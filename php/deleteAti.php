<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/autoload.php';
$rawData = file_get_contents("php://input");
$POST = json_decode($rawData);

$delete = new delete();

if(!empty($POST->id)){

  echo json_encode($delete->deleteQuery(array(array(
      'query' => "DELETE FROM `ati` WHERE `id` = ?",
      'data' => array($POST->id)
  ))));

}


?>
