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

//________________________________________________________________________DISPLAY COMMENTS LIST

    /**
     * Controller method for the admin's home page
     * Returns the list of the unpublished comments submitted by users before validation
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function adminPage(): void
    {
        $this->redirectToLoginIfNotConnected();

        $postList = Post::getPostList();
        $commentsList = Comment::getCommentsPendingList();

        $waitingValidation = null;
        $nothingToValidate = null;

        if ($commentsList !== null) {
            $waitingValidation = "De nouveaux commentaires sont en attente de validation";
        } else {
            $nothingToValidate = "Vous n'avez pas de commentaires en attente de validation.";
        }

        echo $this->render(
            "admin/admin.html.twig",
            array(
                "postList"      => $postList,
                "commentsList"  => $commentsList,

                "Message_A"     => $waitingValidation,
                "Message_B"     => $nothingToValidate
            )
        );
    }
//_________________________________________________________________________PUBLISH COMMENT

    /**
     * Publish a comment object selected by $commentId
     *
     * @return void
     *
     * @param $commentId
     */
    public function publishComment($commentId): void
    {
        $this->redirectToLoginIfNotConnected();

        $comment = Comment::updateComment($commentId);

        try {
            $comment->commentPersist();
        } catch (\Exception $e) {
            //TODO: 404
            echo 'ERROR 404';
        }

        header("Location: /admin");
        exit;
    }

//_________________________________________________________________________REMOVE COMMENT

    /**
     * @param $commentId
     *
     * @return void
     */
    public function deleteComment($commentId): void
    {
        $this->redirectToLoginIfNotConnected();

        Comment::removeComment($commentId);

        header("Location: /admin");
        exit;
    }

//_________________________________________________________________________EDIT POST
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

//_________________________________________________________________________GET POST LIST

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

//_________________________________________________________________________LOGOUT

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
