<?php
namespace App\Conf;

use Conf\DB\DBSettings;

$baseDir = dirname(dirname(dirname(__DIR__)));

include("{$baseDir}/vendor/davcs86/php-mysqlimporter/php-mysqlimporter.php");

class Configuration
{

    /**
     *
     * @var string
     */
    private static $baseUrl;

    /**
     *
     * @var string
     */
    private static $requestUrl;

    /**
     *
     * @param string $siteAdress
     */
    public static function setAdress(string $siteAdress)
    {
        $siteAdress = substr($siteAdress, - 1) == "/" ? substr($siteAdress, 0, - 1) : $siteAdress;
        $array = explode('/', $siteAdress);
        self::$baseUrl = $array[0] . '//' . $array[2] . '/';
        unset($array[0]);
        unset($array[1]);
        unset($array[2]);
        self::$requestUrl = '/' . implode('/', $array);
    }

    /**
     *
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return self::$baseUrl;
    }

    /**
     *
     * @return string
     */
    public static function getRequestUrl(): string
    {
        return self::$requestUrl;
    }

    public static function createDataBase()
    {
        $mysqlImport = new \MySQLImporter(
            DBSettings::DB_HOST,
            DBSettings::DB_USER,
            DBSettings::DB_PASSWORD
        );
        $baseDir = dirname(dirname(dirname(__DIR__)));
        $mysqlImport->doImport(
            "{$baseDir}/cache/tmp/tmp_db.sql",
            DBSettings::DB_NAME
        );
    }
}
