<?php
/**
 * Visitor class file
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
 * Model for visitor
 *
 * @category Models
 * @package  Models
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 *
 * @Entity
 * @Table(name="Visitor")
 */
class Visitor
{
    /**
     * Visitor's id into Visitor table
     *
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    protected $visitorId;

    /**
     * The first name of the visitor
     *
     * @var string $visitorFirstName The first name of the user
     * @Column(type="string")
     */
    protected $visitorFirstName;

    /**
     * The last name of the visitor
     *
     * @var string $visitorLastName The last name of the user
     * @Column(type="string")
     */
    protected $visitorLastName;

    /**
     * The pseudo of the visitor
     *
     * @var string visitorPseudo The pseudo of the user
     * @Column(type="string")
     */
    private $visitorPseudo;

    /**
     * The hash of the visitor's password
     *
     * @var string $visitorPasswordHash The hash of the password
     * @Column(type="string")
     */
    private static $visitorPasswordHash;

    /**
     * The email adress of the visitor
     *
     * @var string $visitorEmail The email of the visitor
     * @Column(type="string")
     */
    protected $visitorEmail;

//__METHODS____________________________________________________________________________________________________

    /**
     * Returns a visitor created into the database
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist()
    {
        $entityManager = Database::getEntityManager();
        $entityManager->persist($this);
        $entityManager->flush();
    }

    /**
     * Returns a visitor with the given pseudo and password or null if it doesn't exist
     *
     * @param string $visitorPseudo       The pseudo of the visitor to return
     * @param string $visitorPasswordHash The password of the visitor to return
     *
     * @return User|null a user with the given username and password or null if it doesn't exist
     */
    public static function getVisitor(string $visitorPseudo, string $visitorPasswordHash): ?Visitor
    {
        $visitorRepository = Database::getEntityManager()->getRepository("Models\\Visitor");
        $visitor = $visitorRepository->findOneBy(
            array(
                "visitorPseudo" => $visitorPseudo
            )
        );

        if ($visitor !== null) {
            if (password_verify($visitorPasswordHash, $visitor->getVisitorPasswordHash())) {
                /**
                 * @noinspection PhpIncompatibleReturnTypeInspection
                 * Safe because $visitor has been generated by Doctrine
                 */
                return $visitor;
            }
        }
        return null;
    }

    /**
     * Returns a visitor from DB or null if it doesn't exist.
     *
     * @param $visitorEmail  string $visitorEmail  The email of the visitor to return
     * @param $visitorPseudo string $visitorPseudo The pseudo of the visitor to return
     *
     * @return Visitor|null
     */
    public static function ifIdentifiersAreValid(string $visitorEmail, string $visitorPseudo): ?visitor
    {
        $visitor = null;

        $visitorRepository = Database::getEntityManager()->getRepository("Models\\Visitor");

        $checkEmail = $visitorRepository->findOneBy(
            array(
                "visitorEmail"  => $visitorEmail
            )
        );

        if ($checkEmail !== null) {
            $visitor = $checkEmail;
            /**
             * @noinspection PhpIncompatibleReturnTypeInspection
             * Safe because $checkEmail has been generated by Doctrine
             */
            return $visitor;
        } else {
            $checkPseudo = $visitorRepository->findOneBy(
                array(
                    "visitorPseudo"  => $visitorPseudo
                )
            );

            if ($checkPseudo !== null) {
                $visitor = $checkPseudo;
                /**
                 * @noinspection PhpIncompatibleReturnTypeInspection
                 * Safe because $checkPseudo has been generated by Doctrine
                 */
                return $visitor;
            }
        }

        if ($visitor !== null) {
            return $visitor;
        } else {
            return null;
        }
    }

//__GETTERS & SETTERS__________________________________________________________________________________________

    /**
     * Returns the visitor's id for the database
     *
     * @return integer the id of the visitor
     */
    public function getVisitorId():int
    {
        return $this->visitorId;
    }

    /**
     * Sets the id of the visitor
     *
     * @param integer $visitorId
     */
    public function setVisitorId($visitorId)
    {
        $this->visitorId = $visitorId;
    }

    /**
     * Returns first name of the visitor
     *
     * @return string The first name of the visitor
     */
    public function getVisitorFirstName(): string
    {
        return $this->visitorFirstName;
    }

    /**
     * Sets first name of the visitor
     *
     * @param string $visitorFirstName
     */
    public function setVisitorFirstName(string $visitorFirstName): void
    {
        $this->visitorFirstName = $visitorFirstName;
    }

    /**
     * Returns last name of the visitor
     *
     * @return string The last name of the visitor
     */
    public function getVisitorLastName(): string
    {
        return $this->visitorLastName;
    }

    /**
     * Sets last name of the visitor
     *
     * @param string $visitorFirstName
     */
    public function setVisitorLastName(string $visitorLastName): void
    {
        $this->visitorLastName = $visitorLastName;
    }

    /**
     * Returns the pseudo of the visitor
     *
     * @return string The pseudo of the visitor
     */
    public function getVisitorPseudo(): string
    {
        return $this->visitorPseudo;
    }

    /**
     * Sets the pseudo of the visitor
     *
     * @param string $visitorPseudo
     */
    public function setVisitorPseudo(string $visitorPseudo)
    {
        $this->visitorPseudo = $visitorPseudo;
    }

    /**
     * Returns the hash of the password's visitor
     *
     * @return string The hash of the password of the visitor
     */
    public static function getVisitorPasswordHash(): string
    {
        return self::$visitorPasswordHash;
    }

    /**
     * Sets the hash of the password of the visitor
     *
     * @param string The hash of the password of the visitor to set
     */
    public function setVisitorPasswordHash(string $visitorPasswordHash)
    {
        self::$visitorPasswordHash = $visitorPasswordHash;
    }

    /**
     * Returns the visitor's email
     *
     * @return string The email of the visitor
     */
    public function getVisitorEmail():string
    {
        return $this->visitorEmail;
    }

    /**
     * Sets the Email adress of the visitor
     *
     * @param string $visitorEmail The email of the visitor
     */
    public function setVisitorEmail(string $visitorEmail)
    {
        $this->visitorEmail = $visitorEmail;
    }
}