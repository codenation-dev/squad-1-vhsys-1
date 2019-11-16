<?php

require __DIR__ . "/../vendor/autoload.php";
$entityManager = (require __DIR__ . "/doctrine.php");

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
