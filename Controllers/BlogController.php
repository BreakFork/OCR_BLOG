<?php
/**
 * BlogController class file
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

use Models\Post;
use Models\Comment;
use Models\Visitor;

/**
 * Controller for the blog pages of the site
 *
 * @category Controllers
 * @package  Controllers
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */
class BlogController extends Controller
{
    /**
     * Controller method to display the list of the posts in users session
     *
     * @return void
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function postList(): void
    {
        $postList = Post::getPostList();

        echo $this->render(
            "postList.html.twig",
            array(
                'userPostList' => $postList
            )
        );
    }

    /**
     * Controller method to display the sign in/sign up form for visitors
     *
     * @return void
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function visitorLoginPage(): void
    {
        $signInErrorMessage = null;
        $signUpErrorMessage = null;

        //_________________________________________________________________________SIGN IN

        if (isset($_POST['visitorPseudo']) && isset($_POST['visitorPassword'])) {
            $visitorPseudo       = $_POST['visitorPseudo'];
            $visitorPasswordHash = $_POST['visitorPassword'];
            $visitor = Visitor::getVisitor($visitorPseudo, $visitorPasswordHash);

            if ($visitor !== null) {
                $_SESSION['visitor']      = $_POST['visitorPseudo'];
                $email   = $visitor->getVisitorEmail();
                $_SESSION['visitorEmail'] = $email;
                header("Location: /");
            } else {
                $signInErrorMessage = 'Ces identifiants sont incorrects';
            }
        }
        //_________________________________________________________________________SIGN UP

        if (isset($_POST['newVisitorEmail']) && isset($_POST['newVisitorPseudo']) && isset($_POST['newVisitorPassword'])) {
           $email    = $_POST['newVisitorEmail'];
           $pseudo   = $_POST['newVisitorPseudo'];
           $password = $_POST['newVisitorPassword'];

           $newVisitor = Visitor::ifIdentifiersAreValid($email, $pseudo);

           if ($newVisitor !==null) {
               $signUpErrorMessage = "Un de ces identifiants est déjà utilisé...";
           } else {
               $newVisitor = new Visitor();

               $newVisitor->setVisitorEmail(trim($email));
               $newVisitor->setVisitorPseudo(trim($pseudo));

               $passwordHash = password_hash($password, PASSWORD_BCRYPT);
               $newVisitor->setVisitorPasswordHash(trim($passwordHash));

               try {
                   $newVisitor->persist();
               } catch (\Exception $e) {
                   $this->redirectTo404ErrorPage();
               }

               $_SESSION['visitor']      = $pseudo;
               $_SESSION['visitorEmail'] = $email;
               header("Location: /");
           }
        }

        echo $this->render("login.html.twig",
            array(
                'signInErrorMessage' => $signInErrorMessage,
                'signUpErrorMessage' => $signUpErrorMessage
            )
        );
    }

    /**
     * Controller method for logout a visitor
     *
     * @return void
     */
    public function logout()
    {
        session_unset();
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    /**
     * Controller method to display a post selected by user in postList using route of the post
     *
     * @param string $postRoute The route of the post
     *
     * @return void
     *
     * @throws \Doctrine\ORM\ORMException
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function post($postRoute): void
    {
        $post = Post::getPostByRoute($postRoute);

        if ($post !== null) {
            $id                  = $post->getId();
            $postTitle           = $post->getPostTitle();
            $lastUpdateTimestamp = $post->getLastUpdateTimestamp();
            $postAuthor          = $post->getPostAuthor();
            $postContent         = $post->getPostContent();

            $noCommentMessage    = null;

            $commentsList        = Comment::getPublishedCommentsList($id);
            if (sizeof($commentsList) < 1) {
                $noCommentMessage = "Il n'y a pas de commentaire pour cet article.\nSoyez le(la) premier(ère) à réagir.";
            }

            $submitMessage = null;

            if (empty($_POST['content'])) {
                $submitMessage = "La validation d'un commentaire peut prendre un certain temps...\nVotre adresse mail ne sera pas publiée.";
            } elseif (isset($_POST['content'])) {
                $commentAuthorName          = $_SESSION['visitor'];
                $commentAuthorEmail         = $_SESSION['visitorEmail'];
                $commentContent             = $_POST['content'];
                $commentLastUpdateTimestamp = time();

                $comment = new Comment();

                $comment->setCommentAuthorName($commentAuthorName);
                $comment->setCommentAuthorEmail($commentAuthorEmail);
                $comment->setCommentContent($commentContent);
                $comment->setCommentLastUpdateTimestamp($commentLastUpdateTimestamp);
                $comment->setCommentEnable(true);
                $comment->setCommentPending(true);

                $comment->setLinkedPost($post);

                $comment->commentPersist();
                $submitMessage = "Votre commentaire a bien été envoyé.";
            }

            echo $this->render(
                "post.html.twig",
                array(
                    "id"                  => $id,
                    "postTitle"           => $postTitle,
                    "lastUpdateTimestamp" => $lastUpdateTimestamp,
                    "postAuthor"          => $postAuthor,
                    "postContent"         => $postContent,

                    "noCommentMessage"    => $noCommentMessage,
                    "commentList"         => $commentsList,

                    "message"             => $submitMessage
                )
            );
        } else {
            $this->redirectTo404ErrorPage();
        }
    }
}
