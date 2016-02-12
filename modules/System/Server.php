<?php
namespace System;

use Ignaszak\Registry\RegistryFactory;

class Server
{

    private static $sendReferDataArray = [];

    private static $readReferDataArray = [];

    public static function getHttpReferer()
    {
        return (! empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :
            RegistryFactory::start('file')->register('Conf\Conf')
                ->getBaseUrl());
    }

    public static function getHttpRequest()
    {
        $conf_req = RegistryFactory::start('file')->register('Conf\Conf')
            ->getRequestUri();
        return ($_SERVER['REQUEST_URI'] != $conf_req ?
            substr(
                $_SERVER['REQUEST_URI'],
                strlen($conf_req) -
                strlen($_SERVER['REQUEST_URI'])
            ) : "");
    }

    public static function headerLocationReferer()
    {
        self::setRefererSession();
        if (! defined('TEST')) {
            header('Location: ' . self::getHttpReferer());
            exit();
        }
    }

    public static function headerLocation(string $location)
    {
        self::setRefererSession();
        if (! defined('TEST')) {
            header('Location: ' . RegistryFactory::start('file')
                ->register('Conf\Conf')->getBaseUrl() . $location);
            exit();
        }
    }

    public static function setReferData(array $data)
    {
        self::$sendReferDataArray = array_merge(self::$sendReferDataArray, $data);
    }

    public static function getReferData()
    {
        return self::$readReferDataArray;
    }

    public static function readReferData()
    {
        self::$readReferDataArray = unserialize(@$_SESSION['systemReferData']);
        unset($_SESSION['systemReferData']);
    }

    public static function setRefererSession()
    {
        $_SESSION['systemReferData'] = serialize(self::$sendReferDataArray);
    }
}
