<?php

namespace Test\Init;

use Ignaszak\Registry\RegistryFactory;
use Test\Mock\MockTest;

class InitConf
{
    public static function run()
    {
        $_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $array = array(
            'getId' => null,
            'getSiteTitle' => null,
            'getAdminEmail' => null,
            'getPostLimit' => null,
            'getDateFormat' => null,
            'getBaseUrl' => null,
            'getRequestUri' => null,
            'getTheme' => null
        );
        MockTest::inject($_conf, 'optionsArray', $array);
    }
}
