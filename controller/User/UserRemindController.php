<?php
namespace Controller\User;

use FrontController\Controller;
use System\Server;
use Content\Controller\Factory;
use Content\Controller\UserController;
use Ignaszak\Registry\RegistryFactory;
use Mail\Mail;
use Mail\MailTransport;

class UserRemindController extends Controller
{

    /**
     *
     * @var \Entity\Users
     */
    private $_userEntity;

    /**
     *
     * @var string
     */
    private $email;

    /**
     *
     * @var string
     */
    private $randomPassword;

    public function run()
    {
        $_user = RegistryFactory::start()->get('user');
        if ($_user->isUserLoggedIn()) {
            Server::headerLocationReferer();
        }

        $this->email = $_POST['userEmail'];

        if (! $this->isEmail($this->email)) {

            Server::setReferData(['error' => ['incorrectEmail' => 1]]);
            Server::headerLocationReferer();

        } else {

            $this->generateRandomPasword();

            $controller = new Factory(new UserController());
            $controller->findOneBy([
                'email' => $this->email
                ]);

            if ($controller->entity() != null) { // If email exists
                $controller->setPassword($this->randomPassword)
                    ->update();
                $this->sendMail($controller->entity()->getLogin());
            } else { // if not
                Server::setReferData(['error' => ['formEmailNotExists' => 1]]);
            }

            Server::setReferData(['form' => 'remind']);
            Server::headerLocationReferer();
        }
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
    private function generateRandomPasword()
    {
        $this->randomPassword = substr(md5(rand(1000, 9999)), 0, 8);
    }

    /**
     *
     * @param string $login
     */
    private function sendMail(string $login)
    {
        $transport = new MailTransport('mail');
        $mail = new Mail($transport->conf());
        $mail->setSubject('Remind password')
            ->setFrom($mail->getAdminEmail())
            ->setTo($this->email)
            ->setBody(
                "Dear {$login}\n" .
                "Your new password is: {$this->randomPassword}\n" .
                "You can change it later in your user account."
            );
        $mail->send();
    }
}
