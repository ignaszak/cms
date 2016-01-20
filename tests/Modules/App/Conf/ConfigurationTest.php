<?php

namespace Test\Modules\App\Conf;

use App\Conf\Configuration;
use Test\Mock\MockTest;
use org\bovigo\vfs\vfsStream as Vsf;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    public function testSetAdressWithRequestUrl()
    {
        $siteAdress = 'http://anyAdress.com/with/request/url';
        Configuration::setAdress($siteAdress);
        $this->assertEquals('http://anyAdress.com/', Configuration::getBaseUrl());
        $this->assertEquals('/with/request/url', Configuration::getRequestUrl());
    }

    public function testSetAdressWithoutRequestUrl()
    {
        $siteAdress = 'http://anyAdress.com/';
        Configuration::setAdress($siteAdress);
        $this->assertEquals('http://anyAdress.com/', Configuration::getBaseUrl());
        $this->assertEquals('/', Configuration::getRequestUrl());
    }

    public function testExecuteSqlFile()
    {
        $stmt = \Mockery::mock('Stmt');
        $stmt->shouldReceive('execute')->once();
        $stmt->shouldReceive('fetch')->once();
        $stmt->shouldReceive('closeCursor')->once();
        $stmt->shouldReceive('nextRowset')->andReturn(false);
        $conn = $this->getMockBuilder('PDO')
            ->disableOriginalConstructor()
            ->getMock();
        $conn->method('prepare')->willReturn($stmt);
        MockTest::callMockMethod(
            'App\Conf\Configuration',
            'executeSqlFile',
            array($conn, $this->mockSqlFile())
        );
    }

    private function mockSqlFile(): string
    {
        $root = Vsf::setup('dir');
        Vsf::newFile('foo')->at($root)->withContent('~');
        return Vsf::url('dir/foo');
    }

}