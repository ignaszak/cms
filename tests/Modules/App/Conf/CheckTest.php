<?php
namespace Test\Modules\App\Conf;

use App\Conf\Check;
use Test\Mock\MockTest;

class CheckTest extends \PHPUnit_Framework_TestCase
{

    public function testExists()
    {
        $check = new Check(MockTest::mockFile('anyFile'));
        $this->assertTrue($check->exists());
    }

    public function testNotExists()
    {
        $check = new Check('NoExistingFileOrFolder');
        $this->assertFalse($check->exists());
    }

    public function testIsReadableWithNoExistingFile()
    {
        $check = new Check('NoExistingFileOrFolder');
        $this->assertFalse($check->isReadable());
    }

    public function testIsReadableWithNoPermissionToRead()
    {
        $check = new Check(MockTest::mockFile('anyFileOrFolder', 0000));
        $this->assertFalse($check->isReadable());
    }

    public function testIsReadable()
    {
        $check = new Check(MockTest::mockFile('anyFileOrFolder', 0440));
        $this->assertTrue($check->isReadable());
    }

    public function testIsWritable()
    {
        $check = new Check(MockTest::mockFile('anyFileOrFolder', 0666));
        $this->assertTrue($check->isWritable());
    }

    public function testIsNotWritable()
    {
        $check = new Check(MockTest::mockFile('anyFileOrFolder', 0444));
        $this->assertFalse($check->isWritable());
    }
}
