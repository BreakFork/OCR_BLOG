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
     * @param int|null $postId
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function postEdit(int $postId = null): void
    {
        $message = null;

        $post = null;

        $postTitle = null;
        $postRoute = null;
        $postAuthor = null;
        $postContent = null;

        if($postId != null) {
            $post = Post::getPost($postId);

            $postTitle = $post->getPostTitle();
            $postRoute = $post->getRoute();
            $postAuthor = $post->getPostAuthor();
            $postContent = $post->getPostContent();
        }

        if (isset($_POST['title']) && isset($_POST['route']) && isset($_POST['author']) && isset($_POST['content']) && isset($_POST['postId'])) {

            $postTitle = $_POST['title'];
            $postRoute = $_POST['route'];
            $postAuthor = $_POST['author'];
            $postContent = $_POST['content'];
            $lastUpdateTimestamp = time();

            if ($post == null) {
                if (!empty($_POST["postId"])) {
                    $post = Post::getPost((int) $_POST["postId"]);
                } else {
                    $post = new Post();
                }
            }

            $post->setPostTitle($postTitle);
            $post->setPostRoute($postRoute);
            $post->setPostAuthor($postAuthor);
            $post->setPostContent($postContent);
            $post->setLastUpdateTimestamp($lastUpdateTimestamp);

            try {
                $post->persist();
                $postId = $post->getId();
                $message = "L'article à été enregistré";
            } catch (\Exception $e) {
                $message = "Une erreur technique est survenue, merci de réessayer ultérieurement.";
                }
            }

            echo $this->render("admin/postEdit.html.twig",
                array(
                    "postId" => $postId,
                    "message" => $message,
                    "postTitle" => $postTitle,
                    "postRoute" => $postRoute,
                    "postAuthor" => $postAuthor,
                    "postContent" => $postContent
                    )
            );
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
