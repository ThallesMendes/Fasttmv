<?php

require_once 'bootstrap.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Fasttmv\Classes\Conexao;

// replace with mechanism to retrieve EntityManager in your app
$entityManager = Conexao::getInstance();

$platform = $entityManager->getConnection()->getSchemaManager()->getDatabasePlatform();
// registra tipo
$platform->registerDoctrineTypeMapping('enum', 'string');

return ConsoleRunner::createHelperSet($entityManager);
