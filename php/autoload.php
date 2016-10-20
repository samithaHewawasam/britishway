<?php

function __autoload($class)
{
    include __DIR__ . '/class/' . $class . '.php';
}

?>
