<?php

include __DIR__ . '/autoload.php';

$filter = new filter();

$getAtis     = $filter->getAtis(array(
    'query' => "SELECT * FROM `ati`",
    'data' => array()
));
$getCourses  = $filter->getCourses(array(
    'query' => "SELECT * FROM `courses`",
    'data' => array()
));
$getSubjects = $filter->getSubjects(array(
    'query' => "SELECT * FROM `subjects`",
    'data' => array()
));
$getSubjectsDetail = $filter->getSubjects(array(
    'query' => "SELECT `subjects`.id, `subject_code`,`subject_name`,`course_name` FROM `subjects` INNER JOIN `courses` ON `courses`.`id` = `subjects`.`course`",
    'data' => array()
));

$getSatCounts = $filter->getSatCounts(array(
    'query' => "SELECT c.id,course_name, SUM(ss.students_sat) sat FROM `students_sat` ss INNER JOIN  `courses` c  ON  c.`id` = ss.`Course` GROUP BY c.id",
    'data' => array()
));

$getCourseToAti = $filter->getCourseToAti(array(
    'query' => "SELECT ac.`id`, `course_name`, `ati_name` FROM `ati_courses` ac INNER JOIN `courses` c ON c.id = ac.`course_id` INNER JOIN ati a ON ac.`ati_id` = a.id",
    'data' => array()
));


echo json_encode(array(
    'atis' => $getAtis,
    'courses' => $getCourses,
    'subjects' => $getSubjects,
    'student_sats' => $getSatCounts,
    'aticourses' => $getCourseToAti,
    'subjectsDetail' => $getSubjectsDetail
));

?>
