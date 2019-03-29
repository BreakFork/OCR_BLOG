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
use Models\Post;

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
                header("Location: /admin");
            } else {
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
    public function adminPage(): void
    {
        echo $this->render("admin/admin.html.twig");
    }

    /**
     * Controller method for the admin to edit a post
     *
     * @return void
     */
    public function postEdit(): void
    {
        $message = null;

        if (isset($_POST['title']) && isset($_POST['route']) && isset($_POST['author']) && isset($_POST['content'])) {
            $postTitle = $_POST['title'];
            $postRoute = $_POST['route'];
            $postAuthor = $_POST['author'];
            $postContent = $_POST['content'];
            $postDateModified = CURRENT_DATE();

            $post = Post::createPost($postTitle, $postRoute, $postAuthor, $postContent, $postDateModified);

            if ($post !== null) {
                $message = "L'article à été enregistré";
            }
        } else {
            $message = "Veuillez remplir tous les champs.";
        }

        echo $this->render("admin/postEdit.html.twig", array("message" => $message,));
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
