<?php
namespace Controller;

use FrontController\Controller as FrontController;
use Ignaszak\Registry\RegistryFactory;
use App\Resource\Server;

class SendMailController extends FrontController
{

    public function run()
    {
        $adminMail = RegistryFactory::start('file')->register('Conf\Conf')
            ->getAdminEmail();

        $transport = \Swift_MailTransport::newInstance();

        $message = \Swift_Message::newInstance()->setSubject('Message from CMS')
            ->setFrom($this->http->request->get('from'))
            ->setTo($adminMail)
            ->setBody($this->http->request->get('body'));

        $mailer = \Swift_Mailer::newInstance($transport);
        $mailer->send($message);

        Server::setReferData(['send' => 1]);
        Server::headerLocationReferer();
    }
}
