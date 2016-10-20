<?php

include __DIR__ . '/autoload.php';
$report = new report();

$getreport = $report->report1(array(
    'query' => "SELECT course_name,COUNT(DISTINCT subject_name) sub_count,
    COUNT(DISTINCT `ati_name`) ati_count,
    COUNT(packet) packet_count,
    SUM(students_sat) student_sat_count
    FROM `students_sat`
    inner join `ati` on `students_sat`.`institute` = `ati`.`id`
    inner join `courses` on `courses`.`id` = `students_sat`.`Course`
    inner join `subjects` on `subjects`.`id` = `students_sat`.`Subject`
    GROUP BY `students_sat`.`Course` WITH ROLLUP ",
    'data' => array()
));
echo json_encode($getreport);
?>
