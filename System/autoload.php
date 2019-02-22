<?php
spl_autoload_register(
    /**
    * @param $class
    */
    function ($class) {
        $class = str_replace("\\", "/", $class);
        include_once("../" . $class . ".php");
    }
);
