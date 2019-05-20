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
            if ($commentsList == null) {
                $noCommentMessage = "Il n'y a pas de commentaire pour cet article.\nSoyez le(la) premier(ère) à réagir.";
            }

            $submitMessage = null;

            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['content'])) {
                $submitMessage = "Veuillez remplir tous les champs.";
            } elseif (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['content'])) {
                $commentAuthorName          = $_POST['name'];
                $commentAuthorEmail         = $_POST['email'];
                $commentContent             = $_POST['content'];
                $commentLastUpdateTimestamp = time();

                $comment = new Comment();

                $comment->setCommentAuthorName($commentAuthorName);
                $comment->setCommentAuthorEmail($commentAuthorEmail);
                $comment->setCommentContent($commentContent);
                $comment->setCommentLastUpdateTimestamp($commentLastUpdateTimestamp);
                $comment->setCommentEnable(false);
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
