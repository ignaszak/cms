<?php

namespace App\Conf;

use Conf\DB\DBSettings;

class Configuration
{

    /**
     * @var string
     */
    private static $baseUrl;

    /**
     * @var string
     */
    private static $requestUrl;

    /**
     * @param string $siteAdress
     */
    public static function setAdress(string $siteAdress)
    {
        $siteAdress = substr($siteAdress, -1) == "/" ?
            substr($siteAdress, 0, -1) : $siteAdress;
        $array = explode('/', $siteAdress);
        self::$baseUrl = $array[0] . '//' . $array[2] . '/';
        unset($array[0]);
        unset($array[1]);
        unset($array[2]);
        self::$requestUrl = '/' . implode('/', $array);
    }

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return self::$baseUrl;
    }

    /**
     * @return string
     */
    public static function getRequestUrl(): string
    {
        return self::$requestUrl;
    }

    public static function createDataBase()
    {
        $conn = new \PDO(
            'mysql:host=' . DBSettings::DB_HOST . ';dbname=' . DBSettings::DB_NAME,
            DBSettings::DB_USER,
            DBSettings::DB_PASSWORD
        );
        $baseDir = dirname(dirname(dirname(__DIR__)));
        self::executeSqlFile($conn, $baseDir . '/cache/tmp/tmp_structure.sql');
        self::executeSqlFile($conn, $baseDir . '/cache/tmp/tmp_data.sql');
    }

    /**
     * @param \PDO $conn
     * @param string $file
     */
    private static function executeSqlFile(\PDO $conn, string $file)
    {
        $sql = file_get_contents($file);
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        do {// Required due to "MySQL has gone away!" issue
            $stmt->fetch();
            $stmt->closeCursor();
        } while ($stmt->nextRowset());
    }

}
