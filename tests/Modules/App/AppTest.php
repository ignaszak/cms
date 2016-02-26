<?php
namespace Test\Modules\App;

use App\App;
use Test\Mock\MockTest;
use Test\Init\InitConf;

class AppTest extends \PHPUnit_Framework_TestCase
{

    private $_app;

    public static function setUpBeforeClass()
    {
        InitConf::setConstants();
    }

    public function setUp()
    {
        $this->_app = new App();
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
        $stub->shouldReceive('loadRegistryConf')->once();
        $stub->shouldReceive('loadSession')->once();
        $stub->shouldReceive('loadRouter')->once();
        $stub->shouldReceive('loadViewHelper')->once();
        $stub->shouldReceive('loadRegistry')->once();
        $stub->shouldReceive('loadAdmin')->once();
        $stub->shouldReceive('loadFrontController')->once();
        $stub->shouldReceive('loadView')->once();
        MockTest::inject($this->_app, '_load', $stub);
        $this->_app->run();
    }

    public function testCatchException()
    {
        $stub = \Mockery::mock('Load');
        $stub->shouldReceive('getException')->once()->andReturnSelf();
        $stub->shouldReceive('catchException')->once();
        MockTest::inject($this->_app, '_load', $stub);
        $this->_app->catchException(null);
    }
}
