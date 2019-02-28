<?php
namespace Controllers;

use Twig_Environment;
use Twig_Loader_Filesystem;

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
 * Controller for the rendering of Twig's template
 *
 * @category Controllers
 * @package  Controllers
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */
class Controller
{
    /**
     * @var Twig_Loader_Filesystem
     * Load the template files (contain the directory path)
     */
    protected $loader;
    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * Instantiates new Controller.
     */
    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem('../Views');
        $this->twig = new Twig_Environment($this->loader, ['cache' => false]);
    }

    /**
     * Render the Twig template.
     *
     * @param string $page
     * @param array $args
     *
     * @return name of the view
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function render(string $page, $args=array()):string
    {
        return $this->twig->render($page, $args);
    }
}
