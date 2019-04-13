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
    public function getUserPostList(): void
    {
        $userPostList = Post::getPostList();

        echo $this->render("userPostList.html.twig",
            array(
                'userPostList' => $userPostList
            )
        );
    }

    /**
     * Controller method to display a post selected from the user's list of posts
     *
     * @return void
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function postFocus(): void
    {
        $postId = null;
        $postTitle = null;
        $postAuthor = null;
        $postContent = null;
        $lastUpdateTimestamp = null;

        if (isset($_POST['postId'])) {
            $postId = $_POST['postId'];

            $post = Post::getPost($postId);

            $postTitle = $post->getPostTitle();
            $postAuthor = $post->getPostAuthor();
            $postContent = $post->getPostContent();
            $lastUpdateTimestamp = $post->getLastUpdateTimestamp();
        }

        echo $this->render("postPageFocus.html.twig",
            array(
                "postTitle" => $postTitle,
                "postAuthor" => $postAuthor,
                "postContent" => $postContent,
                "lastUpdateTimestamp" => $lastUpdateTimestamp
            )
        );
    }

}
