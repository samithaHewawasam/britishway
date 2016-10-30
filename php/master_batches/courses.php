<?php
include __DIR__ . '/../autoload.php';
$master_batches = new master_batches();
echo json_encode($master_batches->index());

 ?>
