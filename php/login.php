<?php session_start();
include __DIR__ . '/autoload.php';

$user = new user();
$login = $user->login(trim($_POST['user_name']), md5(trim($_POST['password'])));

if(!empty($login['data'])){

	$_SESSION['logged'] = true;
	$_SESSION['user']		= $login;
  $_SESSION['menus']	= $user->menu();

	header("Location: ../");

}else{

 $_SESSION['logged'] = false;
 $_SESSION['user']	 = array();
 header("Location: ../login");

}

?>
