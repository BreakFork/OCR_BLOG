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

require_once __DIR__ . '/' . 'autoload.php';
require_once __DIR__ . '/' . '../vendor/autoload.php';

use Controllers\PageController;
use Controllers\AdminController;
use Controllers\BlogController;

session_start();

$path = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

if ($path === "/") {
        $home = new PageController();
        $home->homePage();
} elseif ($path === "/postList") {
        $userList = new BlogController();
        $userList->postList();
} elseif ($path === "/admin/login") {
        $log = new AdminController();
        $log->loginPage();
} elseif ($path === "/admin/postList") {
        $list = new AdminController();
        $list->postList();
} elseif (preg_match ( '/\/admin\/postEdit(\/([\d]*)){0,1}/m', $path, $matches)) {
        $editPost = new AdminController();
        $editPost->postEdit(count($matches) >= 3 ? $matches[2] : null);
} elseif ($path === "/admin/logout") {
        $logout = new AdminController();
        $logout->logoutPage();
} elseif ($path === "/admin") {
        $adminConnected = new AdminController();
        $adminConnected->adminPage();
} else {
    echo 'Router' . '<br>' . 'path&nbsp;:&nbsp;&nbsp;' . $path;
}
