<?php
include __DIR__ . '/../autoload.php';
$raw_data = json_decode(file_get_contents("php://input"));

$master_registrations = new master_registrations();
echo json_encode($master_registrations->findByFeeStructureId($raw_data->fee_id, $raw_data->fullOrIns));

 ?>
