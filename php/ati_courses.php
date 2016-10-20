<?php

include __DIR__ . '/autoload.php';
$rawData = file_get_contents("php://input");
$POST = json_decode($rawData, true);
if(!empty($POST))
$sat = $helper->execPrepare("INSERT INTO `ati_courses`(`course_id`, `ati_id`) VALUES (?, ?)", array($POST['Course'], $POST["Ati"]));

echo json_encode($sat);

?>
