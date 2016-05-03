<?php
namespace Test\Model\App\Resource;

use App\Resource\Http;
use Test\Mock\MockHttp;

class HttpTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Http
     */
    private $http = null;

    public function setUp()
    {
        $this->http = new Http(
            $this->mockResponse(),
            $this->mockRequest()
        );
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(
            'Ignaszak\Router\Response',
            $this->http->router
        );
        $this->assertInstanceOf(
            'Symfony\Component\HttpFoundation\ParameterBag',
            $this->http->request
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidProperty()
    {
        $this->http->invalidProperty;
    }

    public function testIsAdmin()
    {
        $this->http = new Http(
            $this->mockResponse('admin-anyName'),
            $this->mockRequest()
        );
        $this->assertTrue($this->http->isAdmin());
        $this->http = new Http(
            $this->mockResponse('anyName'),
            $this->mockRequest()
        );
        $this->assertFalse($this->http->isAdmin());
    }

    private function mockResponse(string $name = '')
    {
        $stub = $this->getMockBuilder('Ignaszak\Router\Response')
            ->disableOriginalConstructor()->getMock();
        $stub->method('name')->willReturn($name);
        return $stub;
    }

    private function mockRequest()
    {
        $stub = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $stub->request = $this->getMock(
            'Symfony\Component\HttpFoundation\ParameterBag'
        );
        return $stub;
    }
}
