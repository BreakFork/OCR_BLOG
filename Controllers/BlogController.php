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

namespace Doctrine\Common\Collections;
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
            $id                  = $post->getId();
            $postTitle           = $post->getPostTitle();
            $lastUpdateTimestamp = $post->getLastUpdateTimestamp();
            $postAuthor          = $post->getPostAuthor();
            $postContent         = $post->getPostContent();

            $submitMessage = null;

            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['content'])) {
                $submitMessage = "Veuillez remplir tous les champs.";
            } elseif (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['content'])) {

                $commentAuthorName          = $_POST['name'];
                $commentAuthorEmail         = $_POST['email'];
                $commentContent             = $_POST['content'];
                $commentLastUpdateTimestamp = time();
//                $linkedPost                = $id;

                $comment = new Comment();

                $comment->setCommentAuthorName($commentAuthorName);
                $comment->setCommentAuthorEmail($commentAuthorEmail);
                $comment->setCommentContent($commentContent);
                $comment->setCommentLastUpdateTimestamp($commentLastUpdateTimestamp);
                $comment->setCommentPublished(false);

//                $linkedPost = $post->getId();
//                $comment->setLinkedPost($linkedPost);

                $comment->commentPersist();

//                try {
//                    $comment->commentPersist();
//                    $submitMessage = "Votre commentaire a bien été envoyé.";
//                } catch (\Exception $e) {
//                    $submitMessage = "Une erreur technique est survenue, merci de réessayer ultérieurement.";
//                }
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
