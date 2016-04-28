<?php
namespace Controller\User;

use FrontController\Controller as FrontController;
use App\Resource\Server;
use DataBase\Controller\Controller;
use Entity\Users;
use Mail\Mail;
use Mail\MailTransport;

class UserRemindController extends FrontController
{

    /**
     *
     * @var string
     */
    private $randomPassword;

    public function run()
    {
        Server::setReferData(['form' => 'remind']);

        if ($this->registry->get('user')->isUserLoggedIn()) {
            Server::headerLocationReferer();
        }

        $controller = new Controller(new Users());
        $controller->findOneBy([
            'email' => $this->http->request->get('userEmail')
        ]);

        if ($controller->entity() == null) { // If email not exists
            Server::setReferData(['error' => ['findEmail' => 1]]);
            Server::headerLocationReferer();
        } else {
            $this->setRandomPasword();
            $this->updatePassword($controller);
            $this->sendMail($controller);
            Server::setReferData(['remindSuccess' => 1]);
            Server::headerLocationReferer();
        }
    }

    /**
     *
     * @param Controller $controller
     */
    private function updatePassword(Controller $controller)
    {
        $controller->setPassword($this->randomPassword)
            ->update(['password' => []]);
    }

    /**
     *
     * @param string $value
     * @return boolean
     */
    private function isEmail(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @return string
     */
    private function setRandomPasword()
    {
        $this->randomPassword = substr(md5(rand(1000, 9999)), 0, 8);
    }

    /**
     *
     * @param Controller $controller
     */
    private function sendMail(Controller $controller)
    {
        $login = $controller->entity()->getLogin();
        $transport = new MailTransport('mail');
        $mail = new Mail($transport->conf());
        $mail->setSubject('Remind password')
            ->setFrom($mail->getAdminEmail())
            ->setTo($_POST['userEmail'])
            ->setBody(
                "Dear {$login}\n" .
                "Your new password is: {$this->randomPassword}\n" .
                "You can change it later in your user account."
            );
        $mail->send();
    }
}
