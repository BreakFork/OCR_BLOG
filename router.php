<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 08/02/2019
 * Time: 07:21
 */

// require('---/---.php');

echo 'Re, c\'est mon router' . '<br>';

$uri = $_SERVER['REQUEST_URI'];
$displayUri = explode('?' , $uri );


if (isset($_SERVER['REQUEST_URI'])) {
    echo $displayUri[0];
}



