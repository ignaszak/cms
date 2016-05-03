<?php
namespace UserAuth;

require_once __BASEDIR__ . '/vendor/ircmaxell/password-compat/lib/password.php';

class HashPass
{

    /**
     *
     * @var array
     */
    private static $optionsArray = array();

    /**
     *
     * @param array $array
     */
    public static function configure(array $array)
    {
        self::$optionsArray = $array;
    }

    /**
     *
     * @param string $password
     * @return string
     */
    public static function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, self::$optionsArray);
    }

    /**
     *
     * @param string $password
     * @param string $hash
     * @return string
     */
    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
