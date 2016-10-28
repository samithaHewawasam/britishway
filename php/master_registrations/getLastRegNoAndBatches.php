<?php
include __DIR__ . '/../autoload.php';
$raw_data = json_decode(file_get_contents("php://input"));

$master_registrations = new master_registrations();
echo json_encode($master_registrations->getLastRegNoAndBatches($raw_data->course_id));

 ?>
