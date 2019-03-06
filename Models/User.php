<?php
/**
 * User class file
 *
 * PHP Version 7.2
 *
 * @category Model
 * @package  Model
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */

namespace Models;

/**
 * Model for login validation
 *
 * @category Model
 * @package  Model
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */

class User
{
    private static $_user;
    /**
     * First argument of the static method getUser()
     *
     * @var $_username
     */
    private static $_username = "toto";

    /**
     * Second argument of the static method getUser()
     *
     * @var $_passwordhash
     */
    private static $_passwordHash = "pass";

    /**
     * This method compares argument's user with class attributes
     *
     * @param $userName
     * @param $passwordHash
     *
     * @return mixed
     */
    public static function getUser($userName, $passwordHash)
    {
        if ($_POST["pseudo"] = $userName && $_POST["password"] = $passwordHash) {
            self::$_user = new User();
        } else {
            return NULL;
        }
    }

    /**
     * @return mixed
     */
    public static function getUsername()
    {
        return self::$_username;
    }

    /**
     * @param mixed $username
     */
    public static function setUsername($username)
    {
        self::$_username = $username;
    }

    /**
     * @return mixed
     */
    public static function getPasswordHash()
    {
        return self::$_passwordHash;
    }

    /**
     * @param mixed $passwordHash
     */
    public static function setPasswordHash($passwordHash)
    {
        self::$_passwordHash = $passwordHash;
    }
}
