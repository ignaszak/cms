<?php
namespace UserAuth;

require_once __BASEDIR__ . '/vendor/ircmaxell/password-compat/lib/password.php';

class HashPass
{

    private static $optionsArray;

    public static function configure(array $array)
    {
        self::$optionsArray = $array;
    }

    public static function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, self::$optionsArray);
    }

    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
