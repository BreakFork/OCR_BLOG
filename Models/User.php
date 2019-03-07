<?php
/**
 * User class file
 *
 * PHP Version 7.2
 *
 * @category Models
 * @package  Models
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */

namespace Models;

/**
 * Model for user
 *
 * @category Models
 * @package  Models
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */

class User
{
    /**
     * The name of the user
     *
     * @var string $username the name of the user
     */
    private $username;

    /**
     * The hash of the password
     *
     * @var string $passwordhash the hash of the password
     */
    private $passwordHash;

    /**
     * Instantiates a new user
     *
     * @param string $username     the name of the user to set
     * @param string $passwordHash the hash of the password to set
     */
    public function __construct(string $username, string $passwordHash)
    {
        $this->setUsername($username);
        $this->setPasswordHash($passwordHash);
    }

    /**
     * Returns a user with the given username and password or null if it doesn't exist
     *
     * @param string $username the name of the user to return
     * @param string $password the password of the user to return
     *
     * @return User|null a user with the given username and password or null if it doesn't exist
     */
    public static function getUser(string $username, string $password): ?User
    {
        if ($username == "h.boulangue" && $password == "test") {
            return new User($username, self::hashPassword($password));
        }

        return null;
    }

    /**
     * Returns the hash of the given password
     *
     * @param string  $password the password to hash
     *
     * @return string the the hash of the given password
     */
    private static function hashPassword(string $password): string
    {
        return $password;
    }

    /**
     * Returns the name of the user
     *
     * @return string the name of the user
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Returns the setting of the name of the user
     *
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * Returns the hash of the password's user
     *
     * @return string passwordHash
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * Sets the hash of the password of the user
     *
     * @param string the hash of the password of the user to set
     */
    public function setPasswordHash(string $passwordHash)
    {
        $this->passwordHash = $passwordHash;
    }
}
