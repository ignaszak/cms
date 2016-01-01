<?php

namespace Test\Init;

use Ignaszak\Registry\RegistryFactory;

class InitConf
{
    public static function run()
    {
        $find = \Mockery::mock('Find');
        $find->shouldReceive(array(
            'getId' => null,
            'getSiteTitle' => null,
            'getAdminEmail' => null,
            'getPostLimit' => null,
            'getDateFormat' => null,
            'getBaseUrl' => null,
            'getRequestUri' => null,
            'getTheme' => null
        ));
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive(array(
            'find' => $find
        ));
        InitDoctrine::mock($em);
        RegistryFactory::start('file')->register('Conf\Conf');
        InitDoctrine::clear();
    }
}
