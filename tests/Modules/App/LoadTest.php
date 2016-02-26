<?php
namespace Test\Modules\App;

use App\Load;

class LoadTest extends \PHPUnit_Framework_TestCase
{

    private $_load;

    public function setUp()
    {
        $this->_load = new Load;
    }
}
