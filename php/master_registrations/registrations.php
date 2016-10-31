<?php
include __DIR__ . '/../autoload.php';
$master_registrations = new master_registrations();
if(array_key_exists('id', $_GET)){
echo json_encode($master_registrations->index($_GET['id']));
}
?>
