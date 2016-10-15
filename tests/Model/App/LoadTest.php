<?php
namespace Test\Model\App;

use App\Load;
use Test\Mock\MockTest;
use Test\Mock\MockConf;

class LoadTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Load
     */
    private $_load = null;

    public function setUp()
    {
        MockConf::setConstants();
        $reflection = new \ReflectionClass('App\Load');
        $this->_load = $reflection->newInstanceWithoutConstructor();
        MockTest::inject($this->_load, 'confYaml', MockTest::mockFile('conf.yml'));
        MockTest::inject(
            $this->_load,
            'viewHelperYaml',
            MockTest::mockFile('view-helper.yml')
        );
        MockTest::inject(
            $this->_load,
            'adminViewHelperYaml',
            MockTest::mockFile('admin-view-helper.yml')
        );
        $this->_load->__construct();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(
            'App\Admin\AdminExtension',
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

        $this->assertInstanceOf(
            'App\Yaml',
            \PHPUnit_Framework_Assert::readAttribute(
                $this->_load,
                'yaml'
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
        MockTest::inject(
            $this->_load,
            'conf',
            [
                'conf' => ['tmp' => ['router' => MockTest::mockFileSystem([''])]]
            ]
        );
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
