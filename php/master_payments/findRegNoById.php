<?php
include __DIR__ . '/../autoload.php';
$master_payments = new master_payments();
if(array_key_exists('id', $_GET)){
  echo json_encode($master_payments->findRegNoById($_GET['id']));
}
 ?>
