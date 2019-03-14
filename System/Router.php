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
require_once('autoload.php');
require_once('../vendor/autoload.php');

use Controllers\PageController;
use Controllers\AdminController;

$path = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

if ($path === "/") {
        $home = new PageController();
        $home->homePage();
} elseif ($path === "/admin/login") {
        $log = new AdminController();
        $log->loginPage();
        session_start();
} else {
    echo 'Router' . '<br>' . 'path&nbsp;:&nbsp;&nbsp;' . $path;
}
