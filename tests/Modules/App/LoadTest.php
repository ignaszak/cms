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

    public function testConstructor()
    {
        $baseDir = \PHPUnit_Framework_Assert::readAttribute(
            $this->_load,
            'baseDir'
        );
        $this->assertTrue(is_dir($baseDir));
    }
}
