<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(
    array(__DIR__ . "/../src/Entity"),
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);
/*
$conn = [
    'driver' => 'pdo_sqlite',
    'path' =>  __DIR__ . '/../db.sqlite',
];
*/
$conn = [
    'driver' => 'pdo_mysql',
    'host' => '127.0.0.1',
    'port' => '3306',
    'user' => 'root',
    'password'=> '',
    'dbname' => 'central',
    'driverOptions' =>[
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ]
];
// obtaining the entity manager
return EntityManager::create($conn, $config);
