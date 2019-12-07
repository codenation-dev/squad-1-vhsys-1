<?php
//require __DIR__ . '/../bootstrap.php';

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\Tools\Setup;

require_once __DIR__ . '/../vendor/autoload.php';

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/Entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

// configurações do banco de dados
$dbParams = array(
    'driver'   => 'pdo_sqlite',
    'dbname'   => 'memory:tests.db',
);

//cria o entityManager
return $entityManager = EntityManager::create($dbParams, $config);