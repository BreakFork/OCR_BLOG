<?php
/**
 * AdminConnectedController class file
 *
 * PHP Version 7.2
 *
 * @category Controllers
 * @package  Controllers
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */

namespace Controllers;

class AdminConnectedController extends Controller
{
    /**
     * Controller method for the admin page for admin
     *
     * @return void
     */
    public function adminPage()
    {
        $displayAdminName = null;

        if(isset($_SESSION['user'])) {
            $displayAdminName = $_SESSION['user'];
        }
        echo $this->render("admin/admin.html.twig", array("monitoring" => $displayAdminName));
    }

    /**
     * Controller method to redirect to login page if connection stops
     *
     * @return void
     */
    public function redirectToLoginIfNotConnected()
    {
        header("Location: " . $_SERVER['admin/login.html.twig']);
    }
}
