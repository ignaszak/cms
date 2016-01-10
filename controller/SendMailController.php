<?php

namespace Controller;

use FrontController\Controller;
use Ignaszak\Registry\RegistryFactory;
use System\Server;

class SendMailController extends Controller
{

    public function run()
    {
        $adminMail = RegistryFactory::start('file')
            ->register('Conf\Conf')->getAdminEmail();

        $transport = \Swift_MailTransport::newInstance();

        $message = \Swift_Message::newInstance()
            ->setSubject($_POST['subject'])
            ->setFrom($_POST['from'])
            ->setTo($adminMail)
            ->setBody($_POST['body']);

        $mailer = \Swift_Mailer::newInstance($transport);
        $mailer->send($message);

        Server::headerLocationReferer();
    }

}
