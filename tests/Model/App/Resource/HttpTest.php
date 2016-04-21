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
        $stub = $this->getMockBuilder('Ignaszak\Router\Response')
            ->disableOriginalConstructor()->getMock();
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
