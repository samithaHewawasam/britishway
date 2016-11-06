<?php session_start();
include __DIR__ . '/../autoload.php';

$report = new Report();
echo json_encode($report->search($_GET['reg_no']));

?>
