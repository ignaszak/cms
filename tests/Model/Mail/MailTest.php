<?php
namespace Test\Model\Mail;

use Mail\Mail;
use Test\Mock\MockConf;
use Test\Mock\MockTest;

class MailTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Mail\Mail
     */
    private $mail;

    public function setUp()
    {
        MockConf::run(['getAdminEmail' => 'admin@email.com']);
        $stub = \Mockery::mock('alias:Swift_transport');
        $this->mail = new Mail($stub);
    }

    public function testConstructor()
    {
        $this->assertEquals(
            'admin@email.com',
            $this->getAttribute('adminEmail')
        );

        $this->assertInstanceOf(
            'Swift_Message',
            $this->getAttribute('swiftMessage')
        );

        $this->assertInstanceOf(
            'Swift_transport',
            $this->getAttribute('transport')
        );
    }

    public function test__call()
    {
        $stub = \Mockery::mock('SwiftMessage');
        $stub->shouldReceive('setSubject');
        MockTest::inject($this->mail, 'swiftMessage', $stub);
        $this->mail->setSubject();
    }

    public function testGetAdminEmail()
    {
        $this->assertEquals(
            'admin@email.com',
            $this->mail->getAdminEmail()
        );
    }

    private function getAttribute(string $attribute)
    {
        return \PHPUnit_Framework_Assert::readAttribute(
            $this->mail,
            $attribute
        );
    }
}
