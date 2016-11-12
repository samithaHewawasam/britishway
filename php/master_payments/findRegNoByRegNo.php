<?php
include __DIR__ . '/../autoload.php';
$master_payments = new master_payments();
if(array_key_exists('reg_no', $_GET)){
  echo json_encode($master_payments->findRegNoByRegNo($_GET['reg_no']));
}
 ?>
