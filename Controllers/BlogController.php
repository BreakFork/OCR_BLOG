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
}
