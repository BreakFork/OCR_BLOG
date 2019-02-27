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

class PageController extends TwigRender
{
    private $_target = "index";

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        if (!is_string($target)) {
            trigger_error("La page que vous demandez n'existe pas !", E_USER_WARNING);
            return;
        }

        $this->_target = $target;
    }

    /**
     * @return mixed
     */
    public function target()
    {
        return $this->_target;
    }

    /**
     * Controller method for the home page
     *
     * @return void
     */
    public function homePage():void
    {
        self::$page = $this->target();
        parent::renderPage();
    }
}
