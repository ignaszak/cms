<?php
namespace Test\Model\App;

use App\App;
use Test\Mock\MockTest;
use Test\Mock\MockConf;

class AppTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \App\App
     */
    private $app;

    public function setUp()
    {
        MockConf::setConstants();
        $this->app = (new \ReflectionClass('App\App'))
            ->newInstanceWithoutConstructor();
    }

    public function testValidConf()
    {
        $stub = \Mockery::mock('Valid');
        $stub->shouldReceive('validModRewrite')->once();
        $stub->shouldReceive('valid')->once();
        MockTest::inject($this->app, 'valid', $stub);
        $stub = \Mockery::mock('Message');
        $stub->shouldReceive('display')->once();
        MockTest::inject($this->app, 'message', $stub);
        $this->app->validConf();
    }

    public function testRun()
    {
        $stub = \Mockery::mock('Load');
        $stub->shouldReceive('loadExceptionHandler')->once();
        $stub->shouldReceive('loadRegistry')->once();
        $stub->shouldReceive('loadSession')->once();
        $stub->shouldReceive('loadHttp')->once();
        $stub->shouldReceive('loadView')->once();
        $stub->shouldReceive('loadUser')->once();
        $stub->shouldReceive('loadAdmin')->once();
        $stub->shouldReceive('loadFrontController')->once();
        $stub->shouldReceive('loadTheme')->once();
        MockTest::inject($this->app, 'load', $stub);
        $this->app->run();
    }

    public function testCatchException()
    {
        $stub = \Mockery::mock('Load');
        $stub->shouldReceive('getExceptionHandler')->once()->andReturnSelf();
        $stub->shouldReceive('catchException')->once();
        MockTest::inject($this->app, 'load', $stub);
        $this->app->catchException(null);
    }
}
