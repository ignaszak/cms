<?php
namespace Test\Modules\Mail;

use Mail\Mail;
use Test\Init\InitConf;
use Test\Mock\MockTest;

class MailTest extends \PHPUnit_Framework_TestCase
{

    private $_mail;

    public function setUp()
    {
        InitConf::run(['getAdminEmail' => 'admin@email.com']);
        $stub = \Mockery::mock('alias:Swift_Transport');
        $this->_mail = new Mail($stub);
    }

    public function testConstructor()
    {
        $this->assertEquals(
            'admin@email.com',
            $this->getAttribute('adminEmail')
        );

        $this->assertInstanceOf(
            'Swift_Message',
            $this->getAttribute('_swiftMessage')
        );

        $this->assertInstanceOf(
            'Swift_Transport',
            $this->getAttribute('_transport')
        );
    }

    public function test__call()
    {
        $stub = \Mockery::mock('SwiftMessage');
        $stub->shouldReceive('setSubject');
        MockTest::inject($this->_mail, '_swiftMessage', $stub);
        $this->_mail->setSubject();
    }

    public function testGetAdminEmail()
    {
        $this->assertEquals(
            'admin@email.com',
            $this->_mail->getAdminEmail()
        );
    }

    private function getAttribute(string $attribute)
    {
        return \PHPUnit_Framework_Assert::readAttribute(
            $this->_mail,
            $attribute
        );
    }
}
