<?php
/**
 * AdminController class file
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
use Models\User;

/**
 * Controller for the admin pages of the site
 *
 * @category Controllers
 * @package  Controllers
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */
class AdminController extends Controller
{
    /**
     * Controller method for the login page for admin
     *
     * @return void
     */
    public function loginPage(): void
    {
        $errorMessage = null;

        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = User::getUser($username, $password);

            if ($user !== null) {
                $_SESSION['user'] = $_POST['username'];
                $_SESSION['timestamp'] = time();
                header("Location: /admin");
            }
            else {
                $errorMessage = "Vos identifiants sont incorrects. Veuillez réessayer.";
            }
        }

        echo $this->render("admin/login.html.twig", array("error" => $errorMessage,));
    }

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
     * Controller method for logout
     *
     * @return void
     */
    public function logoutPage(): void
    {
        session_unset();
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }


}
