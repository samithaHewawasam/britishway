<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/autoload.php';
$report = new report();

$getreport = $report->report1(array(
    'query' => "SELECT `subject_panel`.`id`, course_name,`subject_name`, `panel_code` FROM `subject_panel` INNER JOIN `subjects` ON `subjects`.id = `subject_panel`.`subject_id` INNER JOIN `courses` ON `courses`.id = `subjects`.course  ",
    'data' => array()
));
echo json_encode($getreport);
?>
