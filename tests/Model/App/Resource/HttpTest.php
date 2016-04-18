<?php
namespace Test\Model\App\Resource;

use App\Resource\Http;

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

    private function mockResponse()
    {
        $stub = \Mockery::mock('alias:Ignaszak\Router\Response');
        return $stub;
    }

    private function mockRequest()
    {
        $stub = \Mockery::mock('alias:Symfony\Component\HttpFoundation\Request');
        $stub->request = \Mockery::mock('alias:Symfony\Component\HttpFoundation\ParameterBag');
        return $stub;
    }
}
