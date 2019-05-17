<?php
/**
 * Database class file
 *
 * PHP Version 7.2
 *
 * @category System
 * @package  System
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */
namespace System;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Class which allow us to get the Entity Manager
 *
 * @category System
 * @package  System
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */
class Database
{
    /**
     * The username to be used for access to database
     */
    private const DB_USERNAME = "new_ocr_blog";

    /**
     * The password to be used for access to database
     */
    private const DB_PASSWORD = "new_ocr_blog";

    /**
     * The name of the database to be used
     */
    private const DB_NAME = "new_ocr_blog";

    /**
     * @var EntityManager|null the Doctrine EntityManager
     */
    private static $entityManager = null;

    /**
     * Returns the Doctrine Entity Manager of the application
     * @return EntityManager|null the Entity Manager or null if an error occurs
     */
    public static function getEntityManager(): ?EntityManager
    {
        if (self::$entityManager === null) {
            $paths = array(__DIR__ . "/" . "../Models");
            $isDevMode = false;

            // the connection configuration
            $dbParams = array(
                'driver'   => 'pdo_mysql',
                'user'     => self::DB_USERNAME,
                'password' => self::DB_PASSWORD,
                'dbname'   => self::DB_NAME,
            );

            $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

            try {
                self::$entityManager = EntityManager::create($dbParams, $config);
            } catch (ORMException $e) {
                return null;
            }
        }
        return self::$entityManager;
    }
}
