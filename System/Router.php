<?php
/**
 * Router file to route user to the expected controller based on url.
 *
 * PHP Version 7.2
 *
 * @category System
 * @package  System
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */
echo 'Re, c\'est mon router' . '<br>';

$uri = $_SERVER['REQUEST_URI'];
$displayUri = explode('?' , $uri );

if (isset($_SERVER['REQUEST_URI'])) { echo $displayUri[0]; }
