<?php
namespace Test\Model\App;

use App\Load;
use Test\Mock\MockTest;

class LoadTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Load
     */
    private $_load = null;

    public function setUp()
    {
        $this->_load = new Load([
            'conf' => [],
            'view-helper' => []
        ]);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(
            'App\AdminExtension',
            \PHPUnit_Framework_Assert::readAttribute(
                $this->_load,
                'adminExtension'
            )
        );

        $this->assertInstanceOf(
            'Ignaszak\Exception\Start',
            $this->_load->getExceptionHandler()
        );

        $this->assertInstanceOf(
            'Ignaszak\Registry\Registry',
            \PHPUnit_Framework_Assert::readAttribute(
                $this->_load,
                'registry'
            )
        );
    }

    public function testDir()
    {
        $this->assertEquals(
            '/anyDir',
            MockTest::callMockMethod($this->_load, 'dir', ['/anyDir'])
            );
    }

    public function testLoadExceptionHandler()
    {
        $stub = \Mockery::mock('ExceptionHandler');
        $stub->shouldReceive('run')->once();
        MockTest::inject($this->_load, 'exceptionHandler', $stub);
        $this->_load->loadExceptionHandler();
    }

    public function testLoadHttp()
    {
        $this->_load = new Load([
           'conf' => ['tmp' => ['router' => MockTest::mockFileSystem([''])]]
        ]);
        MockTest::inject(
            $this->_load,
            'routerYaml',
            MockTest::mockFile('router.yml')
        );
        $this->_load->loadHttp();
        $this->assertInstanceOf(
            'App\Resource\Http',
            \PHPUnit_Framework_Assert::readAttribute(
                $this->_load,
                'http'
            )
        );
    }
}
