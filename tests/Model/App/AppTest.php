<?php
namespace Test\Model\App;

use App\App;
use Test\Mock\MockTest;
use Test\Mock\MockConf;

class AppTest extends \PHPUnit_Framework_TestCase
{

    private $_app;

    public static function setUpBeforeClass()
    {
        MockConf::setConstants();
    }

    public function setUp()
    {
        $reflection = new \ReflectionClass('App\App');
        $this->_app = $reflection->newInstanceWithoutConstructor();
        MockTest::inject($this->_app, 'conf', MockTest::mockFile('conf.yml'));
        MockTest::inject(
            $this->_app, 'viewHelper', MockTest::mockFile('view-helper.yml')
        );
        MockTest::inject(
            $this->_app,
            'adminViewHelper',
            MockTest::mockFile('admin-view-helper.yml')
        );
        $this->_app->__construct();
    }

    public function testConstructor()
    {
        $message = \PHPUnit_Framework_Assert::readAttribute(
            $this->_app,
            '_message'
        );
        $this->assertInstanceOf('App\Message', $message);

        $valid = \PHPUnit_Framework_Assert::readAttribute(
            $this->_app,
            '_valid'
        );
        $this->assertInstanceOf('App\Valid', $valid);

        $load = \PHPUnit_Framework_Assert::readAttribute(
            $this->_app,
            '_load'
        );
        $this->assertInstanceOf('App\Load', $load);

        $yaml = \PHPUnit_Framework_Assert::readAttribute(
            $this->_app,
            '_yaml'
        );
        $this->assertInstanceOf('App\Yaml', $yaml);
    }

    public function testValidConf()
    {
        $stub = \Mockery::mock('Valid');
        $stub->shouldReceive('validModRewrite')->once();
        $stub->shouldReceive('valid')->once();
        MockTest::inject($this->_app, '_valid', $stub);
        $stub = \Mockery::mock('Message');
        $stub->shouldReceive('display')->once();
        MockTest::inject($this->_app, '_message', $stub);
        $this->_app->validConf();
    }

    public function testRun()
    {
        $stub = \Mockery::mock('Load');
        $stub->shouldReceive('loadExceptionHandler')->once();
        $stub->shouldReceive('loadRegistry')->once();
        $stub->shouldReceive('loadSession')->once();
        $stub->shouldReceive('loadHttp')->once();
        $stub->shouldReceive('loadViewHelper')->once();
        $stub->shouldReceive('loadView')->once();
        $stub->shouldReceive('loadUser')->once();
        $stub->shouldReceive('loadAdmin')->once();
        $stub->shouldReceive('loadFrontController')->once();
        $stub->shouldReceive('loadTheme')->once();
        MockTest::inject($this->_app, '_load', $stub);
        $this->_app->run();
    }

    public function testCatchException()
    {
        $stub = \Mockery::mock('Load');
        $stub->shouldReceive('getExceptionHandler')->once()->andReturnSelf();
        $stub->shouldReceive('catchException')->once();
        MockTest::inject($this->_app, '_load', $stub);
        $this->_app->catchException(null);
    }
}
