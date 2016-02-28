<?php
namespace Test\Model\Form;

use Form\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{

    private $_message;

    public function setUp()
    {
        $this->_message = new Message($this->mockForm('anyError'));
    }

    public function testConstructor()
    {
        $errorArray = \PHPUnit_Framework_Assert::readAttribute($this->_message, 'errorArray');
        $this->assertEquals('anyError', $errorArray);
    }

    public function testGetMessage()
    {
        $error = [
            'validLogin' => 1,
            'uniqueEmail' => 1,
            'validPassword' => 1
        ];
        $this->_message = new Message($this->mockForm($error));
        $message = $this->_message->getMessage();
        $this->assertEquals(
            "Inccorect login.<br />Email already exists.<br />Inccorect password.",
            $message
        );
    }

    public function testGetEmptyMessage()
    {
        $error = [];
        $this->_message = new Message($this->mockForm($error));
        $message = $this->_message->getMessage();
        $this->assertEmpty($message);
    }

    private function mockForm($response = []): \Form\Form
    {
        $_form = $this->getMockBuilder('Form\Form')->getMock();
        $_form->method('getFormResponseData')->willReturn($response);
        return $_form;
    }
}
