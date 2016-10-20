<?php
include __DIR__ . '/autoload.php';
$report = new report();

$getreport = $report->report1(array(
    'query' => "SELECT course_name,ati_name,subject_name,packet,students_sat
                            FROM `students_sat` inner join `ati` on `students_sat`.`institute` = `ati`.`id`
                            inner join `courses` on `courses`.`id` = `students_sat`.`Course`
                            inner join `subjects` on `subjects`.`id` = `students_sat`.`Subject`",
                            'data' => array()

));
echo json_encode($getreport);
?>
