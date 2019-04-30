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
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function post($postRoute): void
    {
        $post = Post::getPostByRoute($postRoute);

        if ($post != null) {
            $post = Post::getPostByRoute($postRoute);

            $id                  = $post->getId();
            $postTitle           = $post->getPostTitle();
            $lastUpdateTimestamp = $post->getLastUpdateTimestamp();
            $postAuthor          = $post->getPostAuthor();
            $postContent         = $post->getPostContent();

            $submitMessage = null;

            if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['content'])) {

                $commentPost                = $_POST['postId'];
                $commentAuthorName          = $_POST['name'];
                $commentAuthorEmail         = $_POST['email'];
                $commentContent             = $_POST['content'];
                $commentLastUpdateTimestamp = time();

                $comment = new Comment();

                $comment->setCommentPublished(false);
                $comment->setCommentPost($commentPost);
                $comment->setCommentAuthorName($commentAuthorName);
                $comment->setCommentAuthorEmail($commentAuthorEmail);
                $comment->setCommentContent($commentContent);
                $comment->setCommentLastUpdateTimestamp($commentLastUpdateTimestamp);

                try {
                    $comment->persist();
                    $submitMessage = "Votre commentaire a bien été envoyé.";
                } catch (\Exception $e) {
                    $submitMessage = "Une erreur technique est survenue, merci de réessayer ultérieurement.";
                }
            }

            echo $this->render(
                "post.html.twig",
                array(
                    "id"                         => $id,
                    "postTitle"                  => $postTitle,
                    "lastUpdateTimestamp"        => $lastUpdateTimestamp,
                    "postAuthor"                 => $postAuthor,
                    "postContent"                => $postContent,

                    "message"                    => $submitMessage
                )
            );
        } else {
            //TODO: 404
            echo 'ERROR 404';
        }
    }
}
