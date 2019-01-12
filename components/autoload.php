<?php
    function __autoload($class){
        require '../apiExem/' . $class . '.php';
    }
?>
