<?php
namespace App\Conf;

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
        $siteAdress = substr($siteAdress, - 1) == "/" ?
            substr($siteAdress, 0, - 1) : $siteAdress;
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

    /**
     *
     * @param string $host
     * @param string $dbName
     * @param string $user
     * @param string $password
     * @return boolean
     */
    public static function checkDatabase(
        string $host,
        string $dbName,
        string $user,
        string $password
    ): string {
        try {
            new \PDO(
                "mysql:host={$host};dbname={$dbName}",
                $user,
                $password
            );
            return 'true';
        } catch (\PDOException $e) {
            return 'false';
        }
    }

    /**
     *
     * @param string $login
     * @return boolean
     */
    public static function checkLogin(string $login): string
    {
        return (ctype_alnum($login) && strlen($login) >= 2) ? '' : 'login';
    }

    /**
     *
     * @param string $password
     * @return boolean
     */
    public static function checkPassword(string $password): string
    {
        return (ctype_alnum($password) && strlen($password) >= 8)
            ? '' : 'password';
    }

    /**
     *
     * @param string $email
     * @return boolean
     */
    public static function checkEmail(string $email): string
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? '' : 'email';
    }

    public static function createDataBase()
    {
        $mysqlImport = new \MySQLImporter(
            \Conf\DB\DBSettings::DB_HOST,
            \Conf\DB\DBSettings::DB_USER,
            \Conf\DB\DBSettings::DB_PASSWORD
        );
        $mysqlImport->doImport(
            __BASEDIR__ . "/data/cache/tmp/tmp_db.sql",
            \Conf\DB\DBSettings::DB_NAME
        );
    }
}
