<?php
namespace Test\Init;

use Ignaszak\Registry\RegistryFactory;
use Test\Mock\MockTest;

class InitConf
{

    public static function run(array $data = null)
    {
        $_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $array = array(
            'getId' => null,
            'getSiteTitle' => '',
            'getAdminEmail' => '',
            'getViewLimit' => null,
            'getDateFormat' => '',
            'getBaseUrl' => '',
            'getRequestUri' => '',
            'getTheme' => ''
        );

        if (! is_null($data)) {
            foreach ($data as $key => $value) {
                $array[$key] = $value;
            }
        }

        MockTest::inject($_conf, 'optionsArray', $array);
    }
}
