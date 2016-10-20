<?php
session_start();
include __DIR__ . '/autoload.php';



$user = new user();
$user->setUserName($_POST['user_name']);
$user->setPassword(md5($_POST['password']));
$login = $user->login();

if($login['data'][0]->success == 1){

	$menu = new menu();
	$_SESSION['logged'] = true;
	$_SESSION['menus'] = $menu->getMenus($login['data'][0]->type);
	header("Location: ../");

}else if($login['data'][0]->success == 0){

	echo json_encode($login['error']);
	header("Location: ../login");

}

?>
