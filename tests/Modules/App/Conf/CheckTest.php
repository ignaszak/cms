<?php
namespace Test\Modules\App\Conf;

use App\Conf\Check;
use Test\Mock\MockTest;

class CheckTest extends \PHPUnit_Framework_TestCase
{

    private $_check;

    public function setUp()
    {
        $this->_check = new Check();
    }

    public function testFileExists()
    {
        $this->assertTrue($this->_check->fileExists(MockTest::mockFile('anyFile')));
    }

    public function testFileNotExists()
    {
        $this->assertFalse($this->_check->fileExists('NoExistingFileOrFolder'));
    }

    public function testIsReadableWithNoExistingFile()
    {
        $this->assertFalse($this->_check->isReadable('NoExistingFileOrFolder'));
    }

    public function testIsReadableWithNoPermissionToRead()
    {
        $this->assertFalse($this->_check->isReadable(MockTest::mockFile('anyFileOrFolder', 0000)));
    }

    public function testIsReadable()
    {
        $this->assertTrue($this->_check->isReadable(MockTest::mockFile('anyFileOrFolder', 0440)));
    }

    public function testIsWritable()
    {
        $this->assertTrue($this->_check->isWritable(MockTest::mockFile('anyFileOrFolder', 0666)));
    }

    public function testIsNotWritable()
    {
        $this->assertFalse($this->_check->isWritable(MockTest::mockFile('anyFileOrFolder', 0444)));
    }
}
