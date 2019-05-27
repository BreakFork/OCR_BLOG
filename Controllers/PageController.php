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

namespace Controllers;

/**
 * Controller for the static pages of the site
 *
 * @category Controllers
 * @package  Controllers
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */
class PageController extends Controller
{
    /**
     * Controller method for the home page
     *
     * @return void
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function homePage():void
    {
        if (isset($_POST['lastname'])
            && isset($_POST['firstname'])
            && isset($_POST['email'])
            && isset($_POST['message'])) {
            if (isset($_POST['societe'])) {
                $societe = $_POST['societe'];
            } else {
                $societe = null;
            }
            $to        = 'h.boulangue@gmail.com';
            $lastname  = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $email     = $_POST['email'];
            $subject   = $_POST['subject'];
            $headers   = array(
                'De'      => $firstname . ' ' . $lastname,
                'Email'   => $email,
                'societe' => $societe
            );
            $message   = $_POST['message'];

            mail($to, $subject, $message, $headers);

            $sendMessage = 'Votre email a bien été envoyé';

        } else {
            $sendMessage = "Une question ? Un commentaire ? N'hésitez pas à me laisser un message.";
        }

        echo $this->render("index.html.twig",
            array(
                'sendMessage' => $sendMessage,
            )
        );
    }

    /**
     * Controller method to display the list of the posts
     *
     * @return void
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function postList(): void
    {
        echo $this->render("postList.html.twig");
    }
}
