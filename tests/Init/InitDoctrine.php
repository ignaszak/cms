<?php
namespace Test\Init;

use Conf\DB\DBDoctrine;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Test\Mock\MockTest;

class InitDoctrine
{

    /**
     * Creates connection to test data base
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $db
     * @param string $driver
     *            default pdo_mysql
     * @param string $charset
     *            default utf8
     */
    public static function connect(string $host, string $user, string $password, string $db, string $driver = 'pdo_mysql', string $charset = 'utf8')
    {
        // Configure Doctrine Entity Manager
        $paths = array(
            dirname(dirname(__DIR__)) . '/modules/Entity'
        );
        $isDevMode = true;
        $dbParams = array(
            'driver' => $driver,
            'host' => $host,
            'user' => $user,
            'password' => $password,
            'dbname' => $db,
            'charset' => $charset
        );
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
        $_em = EntityManager::create($dbParams, $config);
        $platform = $_em->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
        
        // Insert Entity Manager to DBDoctrine
        self::mock($_em);
    }

    /**
     * Simple facade to make every InitDoctrine::connect() the same in all tests
     * Please insert yours connection data to test database
     */
    public static function facadeConnection()
    {
        $initDoctrineSettings = __DIR__ . '/InitDoctrineSettings.php';
        if (file_exists($initDoctrineSettings)) {
            $connection = include $initDoctrineSettings;
            self::connect($connection['host'], $connection['user'], $connection['password'], $connection['db']);
        } else {
            throw new \Exception("File '{$initDoctrineSettings}' not found.
Please create 'InitDoctrineSettings.php' file in '" . __DIR__ . "' directory with content:
<?php

return array(
    'host'     => /* host adress */,
    'user'     => /* user name */,
    'password' => /* password */,
    'db'       => /* data base name */
);
");
        }
    }

    /**
     *
     * @param \PHPUnit_Framework_MockObject_Builder_Stub $stub
     */
    public static function mock($stub)
    {
        MockTest::injectStatic('Conf\DB\DBDoctrine', '_em', $stub);
    }

    /**
     * Clear mock entity from \Conf\DB\DBDoctrine
     */
    public static function clear()
    {
        MockTest::injectStatic('Conf\DB\DBDoctrine', '_em');
    }

    /**
     * Create mock createQueryBuilder method
     *
     * @param array $result
     * @return object
     */
    public static function queryBuilder(array $result)
    {
        $queryBuilder = \Mockery::mock('QueryBuilder');
        $queryBuilder->shouldReceive(array(
            'select' => $queryBuilder,
            'from' => $queryBuilder,
            'andwhere' => $queryBuilder,
            'getQuery' => $queryBuilder,
            'setFirstResult' => $queryBuilder,
            'setMaxResults' => $queryBuilder,
            'getSingleScalarResult' => $queryBuilder,
            'setParameter' => $queryBuilder,
            'orderBy' => $queryBuilder,
            'setContentQuery' => $queryBuilder,
            'findBy' => $queryBuilder,
            'getResult' => $result
        ));
        return $queryBuilder;
    }

    /**
     *
     * @param array $result
     */
    public static function queryBuilderResult(array $result)
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive(array(
            'createQueryBuilder' => self::queryBuilder($result),
            'find' => self::queryBuilder($result)
        ));
        self::mock($em);
    }

    public static function repository(array $result)
    {
        $repository = \Mockery::mock('Repository');
        $repository->shouldReceive(array(
            'find' => $result,
            'findBy' => $result
        ));
        return $repository;
    }

    /**
     *
     * @param array $result
     */
    public static function getRepositoryResult(array $result)
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('getRepository')->andReturn(self::repository($result));
        self::mock($em);
    }
}
