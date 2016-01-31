<?php
namespace Test\Modules\Mail;

use Mail\MailTransport;
use Test\Mock\MockTest;

class MailTransportTest extends \PHPUnit_Framework_TestCase
{

    private $_mailTransport;

    public function setUp()
    {
        $this->_mailTransport = new MailTransport("AnyString");
    }

    public function testDefaultTransport()
    {
        $this->assertEquals(
            '\Swift_MailTransport',
            $this->getAttribute('transportClassName')
        );
    }

    public function testSwitchTransport()
    {
        $this->_mailTransport = new MailTransport('smtp');
        $this->assertEquals(
            '\Swift_SmtpTransport',
            $this->getAttribute('transportClassName')
        );
        $this->_mailTransport = new MailTransport('sendMail');
        $this->assertEquals(
            '\Swift_SendmailTransport',
            $this->getAttribute('transportClassName')
        );
        $this->_mailTransport = new MailTransport('mail');
        $this->assertEquals(
            '\Swift_MailTransport',
            $this->getAttribute('transportClassName')
        );
    }

    public function testConfWithNoParams()
    {
        $this->injectMockTransport();
        $this->_mailTransport->conf();
        $this->assertEquals(
            [],
            MockAnySwiftTransport::$array
        );
    }

    public function testConfWithFirstParam()
    {
        $this->injectMockTransport();
        $this->_mailTransport->conf('server for SMTP or command for sendMail');
        $this->assertEquals(
            ['serverOrCommand' => 'server for SMTP or command for sendMail'],
            MockAnySwiftTransport::$array
        );
    }

    public function testConfWithTwoParams()
    {
        $this->injectMockTransport();
        $this->_mailTransport->conf(
            'server for SMTP or command for sendMail',
            1234
        );
        $this->assertEquals(
            [
                'serverOrCommand' => 'server for SMTP or command for sendMail',
                'port' => 1234
            ],
            MockAnySwiftTransport::$array
        );
    }

    public function testConfWithAllParams()
    {
        $this->injectMockTransport();
        $this->_mailTransport->conf(
            'server for SMTP or command for sendMail',
            1234,
            'ssl'
        );
        $this->assertEquals(
            [
                'serverOrCommand' => 'server for SMTP or command for sendMail',
                'port' => 1234,
                'ssl' => 'ssl'
            ],
            MockAnySwiftTransport::$array
        );
    }

    private function injectMockTransport()
    {
        MockTest::inject(
            $this->_mailTransport,
            'transportClassName',
            '\Test\Modules\Mail\MockAnySwiftTransport'
        );
    }

    private function getAttribute(string $attribute)
    {
        return \PHPUnit_Framework_Assert::readAttribute(
            $this->_mailTransport,
            $attribute
        );
    }
}
