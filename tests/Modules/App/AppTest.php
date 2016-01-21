<?php
namespace Test\Modules\App;

use App\App;

class AppTest extends \PHPUnit_Framework_TestCase
{

    private $_app;

    public function setUp()
    {
        $this->_app = new App();
    }
}
