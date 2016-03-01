<?php
namespace Test\Mock;

use Ignaszak\Registry\RegistryFactory;
use Test\Mock\MockTest;

class MockConf
{

    public static function run(array $data = null)
    {
        $_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $array = [
            'getId' => null,
            'getSiteTitle' => '',
            'getAdminEmail' => '',
            'getViewLimit' => null,
            'getDateFormat' => '',
            'getBaseUrl' => '',
            'getRequestUri' => '',
            'getTheme' => ''
        ];

        if (! is_null($data)) {
            foreach ($data as $key => $value) {
                $array[$key] = $value;
            }
        }

        MockTest::inject($_conf, 'optionsArray', $array);
    }

    public static function setConstants()
    {
        if (!defined('__BASEDIR__')) {
            define('__BASEDIR__', '');
            define('__CONFDIR__', '/app/conf');
            define('__VIEWDIR__', '/app/view');
            define('__ADMINDIR__', '/app/admin');
            define('ADMIN_FOLDER', 'admin');
            define('ADMIN_URL', 'admin');
        }
    }
}
