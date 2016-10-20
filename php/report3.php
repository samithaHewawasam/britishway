<?php
include __DIR__ . '/autoload.php';
$report = new report();

$getreport = $report->report1(array(
    'query' => "SELECT IFNULL(`ati`.`ati_name`, 'ATI WISE TOTAL') AS ati_name,
    IFNULL(`courses`.`course_name`, 'Course WISE TOTAL') AS course_name,
    COUNT(DISTINCT `subjects`.subject_name) sub_count,
    COUNT(DISTINCT `ati_name`) ati_count,
    COUNT(`students_sat`.packet) packet_count,
    SUM(`students_sat`.students_sat) student_sat_count FROM `students_sat`
    inner join `ati` on `students_sat`.`institute` = `ati`.`id`
    inner join `courses` on `courses`.`id` = `students_sat`.`Course`
    inner join `subjects` on `subjects`.`id` = `students_sat`.`Subject`
    GROUP BY `ati_name`, `course_name` WITH ROLLUP  ",
    'data' => array()
));
echo json_encode($getreport);
?>
