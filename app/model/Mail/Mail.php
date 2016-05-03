<?php
namespace Mail;

use Ignaszak\Registry\RegistryFactory;
use Swift_Message;
use Swift_Mailer;

class Mail
{

    /**
     *
     * @var \Swift_Transport
     */
    private $transport = null;

    /**
     *
     * @var \Swift_Message
     */
    private $swiftMessage = null;

    /**
     *
     * @var string
     */
    private $adminEmail = '';

    /**
     *
     * @param \Swift_Transport $transport
     */
    public function __construct(\Swift_Transport $transport)
    {
        $this->adminEmail = RegistryFactory::start('file')
            ->register('Conf\Conf')->getAdminEmail();

        $this->swiftMessage = Swift_Message::newInstance();
        $this->transport = $transport;
    }

    /**
     *
     * @param string $function
     * @param array $args
     * @return mixed
     */
    public function __call(string $function, array $args)
    {
        return call_user_func_array([$this->swiftMessage, $function], $args);
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
        $mailer = Swift_Mailer::newInstance($this->transport);
        $mailer->send($this->swiftMessage);
    }
}
