<?php

include __DIR__ . '/autoload.php';

$filter = new filter();

$getSat    = $filter->getSat(array(
    'query' => "SELECT a.`ati_name`,c.`course_name`, s.`subject_name`, SUM(ss.students_sat) sat FROM `students_sat` ss INNER JOIN  `courses` c  ON  c.`id` = ss.`Course` INNER JOIN subjects s ON s.id = ss.`Subject` INNER JOIN ati a ON a.id = ss.`institute`  WHERE c.id = ? GROUP BY ss.`institute`,ss.`Course`,ss.`Subject`",
    'data' => array($_GET['id'])
));

echo json_encode(array(
    'sat' => $getSat
));

?>
