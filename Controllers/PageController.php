<?php
/**
 * PageController class file
 *
 * PHP Version 7.2
 *
 * @category Controllers
 * @package  Controllers
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */

/**
 * Controller for the static pages of the site
 *
 * @category Controllers
 * @package  Controllers
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */

namespace Controllers;

use Twig_Environment;
use Twig_Loader_Filesystem;

class PageController
{
    /**
     * Controller method for the home page
     *
     * @return void
     */
    public function homePage():void
    {
        $loader = new Twig_Loader_Filesystem('../Views');
        $twig = new Twig_Environment($loader, ['cache' => false]);
        echo $twig->render('index.html.twig');
    }
}
