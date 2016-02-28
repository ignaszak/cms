<?php
namespace Test\Model\App;

use App\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{

    private $_message;

    public function setUp()
    {
        $this->_message = new Message();
    }

    public function testCatchWithEmptyMessage()
    {
        $_check = $this->mockCheck(array());
        $this->_message->catch($_check);
        $this->assertEmpty($this->getMessageArray());
    }

    public function testCatchWithMessage()
    {
        $_check = $this->mockCheck(array('Some Message'));
        $this->_message->catch($_check);
        $this->assertNotEmpty($this->getMessageArray());
    }

    public function testCatchMessage()
    {
        $this->_message->catchMessage('Any Message');
        $this->assertTrue(in_array('Any Message', $this->getMessageArray()));
    }

    private function mockCheck(array $return): \App\Conf\Check
    {
        $stub = $this->getMockBuilder('\App\Conf\Check')
            ->disableOriginalConstructor()
            ->getMock();
        $stub->method('getMessage')->willReturn($return);
        return $stub;
    }

    private function getMessageArray(): array
    {
        return \PHPUnit_Framework_Assert::readAttribute(
            $this->_message,
            'messageArray'
        );
    }
}
