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
            'getSiteTitle' => '',
            'getAdminEmail' => '',
            'getPostLimit' => null,
            'getDateFormat' => '',
            'getBaseUrl' => '',
            'getRequestUri' => '',
            'getTheme' => ''
        );
        MockTest::inject($_conf, 'optionsArray', $array);
    }
}
