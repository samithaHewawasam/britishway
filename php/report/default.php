<?php
include __DIR__ . '/../autoload.php';

$report = new Report();
echo json_encode($report->index());

?>
