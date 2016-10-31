<?php
include __DIR__ . '/../autoload.php';
$master_payments = new master_payments();
echo json_encode($master_payments->index());

 ?>
