<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require __DIR__ . '/conf/Conf.php';
$conf = Conf::instance(); // Create conf object

$loader = require __DIR__ . '/vendor/autoload.php';

$paths = array( __DIR__ . '/modules/Entity' );
$isDevMode = true;

// the connection configuration
$dbParams = array(
    'driver'    => 'pdo_mysql',
    'host'      => 'localhost',
    'user'      => 'root',
    'password'  => 'przeznaczenie',
    'dbname'    => 'cms',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
