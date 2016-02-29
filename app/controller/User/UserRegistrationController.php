<?php
namespace Controller\User;

use FrontController\Controller as FrontController;
use App\Resource\Server;
use DataBase\Controller\Controller;
use Ignaszak\Registry\RegistryFactory;
use Mail\Mail;
use Mail\MailTransport;
use Entity\Users;

class UserRegistrationController extends FrontController
{

    /**
     *
     * @var string
     */
    private $login;

    /**
     *
     * @var string
     */
    private $email;

    /**
     *
     * @var string
     */
    private $password;

    public function run()
    {
        Server::setReferData(['form' => 'registration']);
        $_user = RegistryFactory::start()->get('user');

        if ($_user->isUserLoggedIn()) {
            Server::setReferData(['error' => ['userMustBeLogout' => 1]]);
            Server::headerLocationReferer();
        }

        $this->login = $_POST['userLogin'];
        $this->email = $_POST['userEmail'];
        $this->password = $_POST['userPassword'];

        $controller = new Controller(new Users());
        $controller->setLogin($this->login)
            ->setEmail($this->email)
            ->setPassword($this->password)
            ->setRegDate(new \DateTime('now'))
            ->setLogDate(new \DateTime('now'))
            ->setRole('user')
            ->insert([
                'login' => ['unique'],
                'email' => ['unique'],
                'password' => []
            ]);

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
                "Welcome {$this->login} on {$this->view()->getSiteTitle()}.\n" .
                "Thank you for registering at our site. You can find your credentials below:\n" .
                "Login: {$this->login}\nPassword: {$this->password}\nEmail: {$this->email}"
            );
        $mail->send();
    }
}
