<?php

namespace Conf\DB;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DBDoctrine
{

    private static $entityManager;

    public static function configure()
    {
        self::setConnectionConfigurationAndEntityManager();
        self::registerEnumTypeAsDoctrineVarchar();
    }

    public static function getEntityManager()
    {
        return self::$entityManager;
    }

    private static function setConnectionConfigurationAndEntityManager()
    {
        $paths = array(dirname(dirname(__DIR__)) . '/modules/Entity');
        $isDevMode = true;

        $dbParams = array(
            'driver'    => 'pdo_mysql',
            'host'      => DBSettings::DB_HOST,
            'user'      => DBSettings::DB_USER,
            'password'  => DBSettings::DB_PASSWORD,
            'dbname'    => DBSettings::DB_NAME,
            'charset'   => 'utf8'
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
        self::$entityManager = EntityManager::create($dbParams, $config);
    }

    private static function registerEnumTypeAsDoctrineVarchar()
    {
        $platform = self::$entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
    }

}
