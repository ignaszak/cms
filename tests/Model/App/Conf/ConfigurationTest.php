<?php
namespace Test\Model\App\Conf;

use App\Conf\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    public function testSetAdressWithRequestUrl()
    {
        $siteAdress = 'http://anyAdress.com/with/request/url';
        Configuration::setAdress($siteAdress);
        $this->assertEquals(
            'http://anyAdress.com/with/request/url',
            Configuration::$siteAdress
        );
        $this->assertEquals('/with/request/url', Configuration::$requestUrl);
    }

    public function testSetAdressWithoutRequestUrl()
    {
        $siteAdress = 'http://anyAdress.com/';
        Configuration::setAdress($siteAdress);
        $this->assertEquals('http://anyAdress.com', Configuration::$siteAdress);
        $this->assertEquals('', Configuration::$requestUrl);
    }
}
