<?php
namespace Controller\User;

use Auth\Auth;
use FrontController\Controller as FrontController;
use App\Resource\Server;
use DataBase\Command\Command;
use Mail\Mail;
use Mail\MailTransport;
use Entity\Users;

class UserRegistrationController extends FrontController
{

    /**
     *
     * @var string
     */
    private $login = '';

    /**
     *
     * @var string
     */
    private $email = '';

    /**
     *
     * @var string
     */
    private $password = '';

    public function run()
    {
        Server::setReferData(['form' => 'registration']);

        if ($this->registry->get('user')->isUserLoggedIn()) {
            Server::setReferData(['error' => ['userMustBeLogout' => 1]]);
            Server::headerLocationReferer();
        }

        $this->login = $this->http->request->get('userLogin');
        $this->email = $this->http->request->get('userEmail');
        $this->password = $this->http->request->get('userPassword');

        $command = new Command(new Users());
        $command->setLogin($this->login)
            ->setEmail($this->email)
            ->setPassword($this->password)
            ->setRole('user');
        $auth = new Auth($command);
        $auth->register();

        $this->sendMail();

        Server::setReferData(['registrationSuccess' => 1]);
        Server::headerLocationReferer();
    }

    private function sendMail()
    {
        $mailTransport = new MailTransport('mail');
        $mail = new Mail($mailTransport->conf());
        $mail->setSubject('Registration successful')
            ->setFrom($mail->getAdminEmail())
            ->setTo($this->email)
            ->setBody(
                "Welcome {$this->login} on {$this->view->getSiteTitle()}.\n" .
                "Thank you for registering at our site. You can find your credentials below:\n" .
                "Login: {$this->login}\nPassword: {$this->password}\nEmail: {$this->email}"
            );
        $mail->send();
    }
}
