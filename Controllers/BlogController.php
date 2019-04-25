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

        echo $this->render("postList.html.twig",
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

            $postTitle           = $post->getPostTitle();
            $lastUpdateTimestamp = $post->getLastUpdateTimestamp();
            $postAuthor          = $post->getPostAuthor();
            $postContent         = $post->getPostContent();

            echo $this->render("post.html.twig",
                array(
                    "postTitle"           => $postTitle,
                    "lastUpdateTimestamp" => $lastUpdateTimestamp,
                    "postAuthor"          => $postAuthor,
                    "postContent"         => $postContent
                )
            );
        } else {
            //TODO: 404
            echo 'ERROR 404';
        }
    }
}
