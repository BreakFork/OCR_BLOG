<?php
require_once __DIR__ . '/' . "../vendor/autoload.php";
require_once __DIR__ . '/' . "../System/autoload.php";

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use System\Database;

return ConsoleRunner::createHelperSet(Database::getEntityManager());
