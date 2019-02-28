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
    protected $loader;
    protected $twig;

    /**
     * Instantiates new controller.
     */
    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem('../Views');
        $this->twig = new Twig_Environment($this->loader, ['cache' => false]);
    }

    /**
     * This is what my method is doing
     *
     * @param string $page
     * @param array $args
     *
     * @return string this is what my method returns
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
