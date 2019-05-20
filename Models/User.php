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

use System\Database;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * Model for user
 *
 * @category Models
 * @package  Models
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 *
 * @Entity
 * @Table(name="User")
 */
class User
{
    /**
     * User's id into User table
     *
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * The name of the user
     *
     * @var string $username the name of the user
     *
     * @Column(type="string")
     */
    private $username;

    /**
     * The hash of the password
     *
     * @var string $passwordHash the hash of the password
     *
     * @Column(type="string")
     */
    private static $passwordHash;

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
        $userRepository = Database::getEntityManager()->getRepository("Models\\User");
        $user = $userRepository->findOneBy(
            array(
                "username" => $username
            )
        );

        if ($user !== null) {
            if (password_verify($password, $user->getPasswordHash())) {
                /**
                 * @noinspection PhpIncompatibleReturnTypeInspection
                 * Safe because $user has been generated by Doctrine
                 */
                return $user;
            }
        }
        return null;
    }

    /**
     * Returns the user's id for the database
     *
     * @return integer the id of the user
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id of the user
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Sets the name of the user
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
     * @return string the hash of the password of the user
     */
    public static function getPasswordHash(): string
    {
        return self::$passwordHash;
    }

    /**
     * Sets the hash of the password of the user
     *
     * @param string the hash of the password of the user to set
     */
    public function setPasswordHash(string $passwordHash)
    {
        self::$passwordHash = $passwordHash;
    }
}
