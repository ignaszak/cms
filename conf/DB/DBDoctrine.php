<?php

namespace Conf\DB;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DBDoctrine
{

    /**
     * @var EntityManager
     */
    private static $_em;

    /**
     * @return EntityManager
     */
    public static function em($_emMock = null)
    {
        if (empty($_emMock)) { // Normal use
            if (empty(self::$_em))
                self::configure();

            return self::$_em;
        } else { // For testing
            self::$_em = $_emMock;
            return self::$_em;
        }
    }

    private static function configure()
    {
        self::setConnectionConfigurationAndEntityManager();
        self::registerEnumTypeAsDoctrineVarchar();
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
        self::$_em = EntityManager::create($dbParams, $config);
    }

    private static function registerEnumTypeAsDoctrineVarchar()
    {
        $platform = self::$_em->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
    }

}
