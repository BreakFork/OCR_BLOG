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
use Models\Comment;

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
    //___________________________________________________________________LOGIN
    /**
     * Controller method for the login page for admin
     *
     * @return void
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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

    //____________________________________________________________________DISPLAY / PUBLISH / DELETE PENDING COMMENTS

    /**
     * Controller method for the admin's home page
     * Displays the list of the unpublished comments submitted by users before validation
     *
     * @return void
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function adminPage(): void
    {
        $this->redirectToLoginIfNotConnected();

        $waitingValidation = null;
        $nothingToValidate = null;
        $editMessage = null;

        if (isset($_POST["publishAction"]) && isset($_POST['commentId'])) {
            $comment = Comment::updateComment($_POST['commentId']);

            try {
                $comment->commentPersist();
                $editMessage = "Le commentaire a bien été publié";
            } catch (\Exception $e) {
                //TODO: 404
                echo 'ERROR 404';
            }
        }

        if (isset($_POST["deleteAction"]) && isset($_POST['commentId'])) {
            Comment::removeComment($_POST['commentId']);

            $editMessage = "Le commentaire a bien été effacé";
        }

        $postList = Post::getPostList();
        $commentsList = Comment::getCommentsPendingList();

        if ($commentsList !== null) {
            $waitingValidation = "Des commentaires sont en attente de validation";
        } else {
            $nothingToValidate = "Vous n'avez pas de commentaires en attente de validation";
        }

        echo $this->render(
            "admin/admin.html.twig",
            array(
                "postList"                 => $postList,
                "commentsList"             => $commentsList,

                "waitingValidationMessage" => $waitingValidation,
                "nothingToValidateMessage" => $nothingToValidate,
                "editMessage"              => $editMessage
            )
        );
    }

    //____________________________________________________________________EDIT POST
    /**
     * Controller method for the admin to edit a post
     *
     * @param int|null $postId
     *
     * @return void
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function postEdit(int $postId = null): void
    {
        $this->redirectToLoginIfNotConnected();

        $message = null;

        $post = null;

        $postTitle = null;
        $postRoute = null;
        $postAuthor = null;
        $postContent = null;
        $pageTitle = null;

        if ($postId != null) {
            $post = Post::getPost($postId);

            $postTitle = $post->getPostTitle();
            $postRoute = $post->getPostRoute();
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
                    $post = Post::getPost((int)$_POST["postId"]);
                } else {
                    $post = new Post();
                }
            }

            $post->setPostTitle(trim($postTitle));
            $post->setPostRoute(trim($postRoute));
            $post->setPostAuthor(trim($postAuthor));
            $post->setPostContent(trim($postContent));
            $post->setLastUpdateTimestamp($lastUpdateTimestamp);

            try {
                $post->persist();
                $postId = $post->getId();
                $message = "L'article à été enregistré";
            } catch (\Exception $e) {
                $message = "Une erreur technique est survenue, merci de réessayer ultérieurement.";
            }
        }

        echo $this->render(
            "admin/postEdit.html.twig",
            array(
                "postId"      => $postId,
                "message"     => $message,
                "postTitle"   => $postTitle,
                "postRoute"   => $postRoute,
                "postAuthor"  => $postAuthor,
                "postContent" => $postContent,
                "pageTitle"   => $pageTitle
            )
        );
    }

    //_____________________________________________________________________GET POST LIST

    /**
     * Controller method to display the list of the posts in admin session
     *
     * @return void
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function postList(): void
    {
        $this->redirectToLoginIfNotConnected();

        $postList = Post::getPostList();

            echo $this->render(
                "admin/postList.html.twig",
                array(
                    'postList' => $postList
                )
            );
    }

    //_____________________________________________________________________LOGOUT

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
