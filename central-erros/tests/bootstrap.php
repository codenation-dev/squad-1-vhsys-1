<?php
require __DIR__ . '/../bootstrap.php';

use Doctrine\ORM\EntityManager;

// configurações do banco de dados
$dbParams = array(
    'driver'   => 'pdo_sqlite',
    'dbname'   => 'memory:tests.db',
);

//cria o entityManager
return $entityManager = EntityManager::create($dbParams, $config);