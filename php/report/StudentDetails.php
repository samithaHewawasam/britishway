<?php
include __DIR__ . '/../autoload.php';
$raw_data = json_decode(file_get_contents("php://input"));
$report = new Report();
echo json_encode($report->StudentDetails($raw_data));

?>
