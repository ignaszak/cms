<?php
namespace Test\Model\App\Conf;

use App\Conf\Check;
use Test\Mock\MockTest;

class CheckTest extends \PHPUnit_Framework_TestCase
{
    private $_check;

    public function setUp()
    {
        $this->_check = new Check;
    }

    public function testExists()
    {
        $this->_check->add(MockTest::mockFile('anyFile'));
        $this->assertTrue($this->_check->exists());
    }

    public function testNotExists()
    {
        $this->_check->add('NoExistingFileOrFolder');
        $this->assertFalse($this->_check->exists());
    }

    public function testIsReadableWithNoExistingFile()
    {
        $this->_check->add('NoExistingFileOrFolder');
        $this->assertFalse($this->_check->isReadable());
    }

    public function testIsReadableWithNoPermissionToRead()
    {
        $this->_check->add(MockTest::mockFile('anyFileOrFolder', 0000));
        $this->assertFalse($this->_check->isReadable());
    }

    public function testIsReadable()
    {
        $this->_check->add(MockTest::mockFile('anyFileOrFolder', 0440));
        $this->assertTrue($this->_check->isReadable());
    }

    public function testIsWritable()
    {
        $this->_check->add(MockTest::mockFile('anyFileOrFolder', 0666));
        $this->assertTrue($this->_check->isWritable());
    }

    public function testIsNotWritable()
    {
        $this->_check->add(MockTest::mockFile('anyFileOrFolder', 0444));
        $this->assertFalse($this->_check->isWritable());
    }
}
