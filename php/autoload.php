<?php session_start();

function __autoload($class)
{
    include __DIR__ . '/class/' . $class . '.php';
}


  if(!empty($_SESSION['user']['data'])){
    define('USER', $_SESSION['user']['data'][0]->user_display_name);
    define('USER_ID', $_SESSION['user']['data'][0]->id);
  }

?>
