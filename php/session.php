<?php
// begin the session
session_start();
if(empty($_SESSION['logged'])){
echo json_encode(false);
}else{
echo json_encode(true);
}
?>
