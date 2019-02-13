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

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('Views/index.html');

$twig = new Twig_Environment($loader, [
    'cache' => 'compilation_cache',
]);

class PageController
{
    /**
     * Controller method for the home page
     *
     * @return index.html.twig
     */
    public function homePage()
    {
        $twig->load('index.html');
    }
}
