<?php
include __DIR__ . '/../autoload.php';

$master_registrations = new master_registrations();
echo json_encode($master_registrations->coursesAndBatches($_GET['course_id']));

?>
