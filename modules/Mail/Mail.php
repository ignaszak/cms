<?php
namespace Mail;

use Ignaszak\Registry\RegistryFactory;
use Swift_Message;
use Swift_Mailer;

class Mail
{

    /**
     *
     * @var unknown
     */
    private $_transport;

    /**
     *
     * @var \Swift_Message
     */
    private $_swiftMessage;

    /**
     *
     * @var string
     */
    private $adminEmail;

    /**
     *
     * @param \Swift_Transport $_transport
     */
    public function __construct(\Swift_Transport $_transport)
    {
        $this->adminEmail = RegistryFactory::start('file')
            ->register('Conf\Conf')->getAdminEmail();

        $this->_swiftMessage = Swift_Message::newInstance();
        $this->_transport = $_transport;
    }

    /**
     *
     * @param string $function
     * @param array $args
     * @throws InvalidMethodException
     * @return mixed
     */
    public function __call(string $function, array $args)
    {
        return call_user_func_array(
            array(
                $this->_swiftMessage,
                $function
            ),
            $args
        );
    }

    /**
     * @return string
     */
    public function getAdminEmail(): string
    {
        return $this->adminEmail;
    }

    public function send()
    {
        $mailer = Swift_Mailer::newInstance($this->_transport);
        $mailer->send($this->_swiftMessage);
    }
}
