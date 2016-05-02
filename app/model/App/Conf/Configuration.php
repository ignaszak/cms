<?php
namespace App\Conf;

class Configuration
{

    /**
     *
     * @var string
     */
    public static $siteAdress;

    /**
     *
     * @var string
     */
    public static $requestUrl;

    /**
     *
     * @var string
     */
    public static $dbHost;

    /**
     *
     * @var string
     */
    public static $dbUser;

    /**
     *
     * @var string
     */
    public static $dbPassword;

    /**
     *
     * @var string
     */
    public static $dbName;

    /**
     *
     * @var string
     */
    public static $login;

    /**
     *
     * @var string
     */
    public static $password;

    /**
     *
     * @var string
     */
    public static $email;

    /**
     *
     * @param string $siteAdress
     */
    public static function setAdress($siteAdress)
    {
        $siteAdress = substr($siteAdress, - 1) == "/" ?
            substr($siteAdress, 0, strlen($siteAdress) - 1) : $siteAdress;
        self::$siteAdress = $siteAdress;
        $array = explode('/', $siteAdress);
        unset($array[0], $array[1], $array[2]);
        $requestUrl = implode('/', $array);
        self::$requestUrl = empty($requestUrl) ? '' : "/{$requestUrl}";
    }

    /**
     *
     * @param string $host
     * @param string $dbName
     * @param string $user
     * @param string $password
     * @return boolean
     */
    public static function checkDatabase($host, $name, $user, $password)
    {
        try {
            new \PDO(
                "mysql:host={$host};dbname={$name}",
                $user,
                $password
            );
            self::$dbHost = $host;
            self::$dbName = $name;
            self::$dbUser = $user;
            self::$dbPassword = $password;
            return 'true';
        } catch (\PDOException $e) {
            return 'false';
        }
    }

    /**
     *
     * @param string $adress
     * @return boolean
     */
    public static function checkAdress($adress)
    {
        return filter_var($adress, FILTER_VALIDATE_URL);
    }

    /**
     *
     * @param string $login
     * @return string
     */
    public static function checkLogin($login)
    {
        self::$login = $login;
        return (ctype_alnum($login) && strlen($login) >= 2) ? '' : 'login';
    }

    /**
     *
     * @param string $password
     * @return string
     */
    public static function checkPassword($password)
    {
        self::$password = $password;
        return (ctype_alnum($password) && strlen($password) >= 8)
            ? '' : 'password';
    }

    /**
     *
     * @param string $email
     * @return string
     */
    public static function checkEmail($email)
    {
        self::$email = $email;
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
            __BASEDIR__ . "/data/cache/tmp_db.sql",
            \Conf\DB\DBSettings::DB_NAME
        );
    }
}
