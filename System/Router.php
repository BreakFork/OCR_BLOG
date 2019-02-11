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

$path = explode('?' , $_SERVER['REQUEST_URI'], 2 )[0];

echo 'Router' . '<br>' . 'path&nbsp;:&nbsp;&nbsp;' . $path;
