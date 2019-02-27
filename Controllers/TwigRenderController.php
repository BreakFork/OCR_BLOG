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
 * Controller for the rendering of Twig's template
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

class TwigRenderController
{
    protected $loader;
    protected $twig;
    protected $page;
    protected $arg;

    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem('../Views');
        $this->twig = new Twig_Environment($this->loader, ['cache' => false]);
    }

    protected function render(string $page, $args=null)
    {
        return $this->twig->render($page, $args);
    }
}
