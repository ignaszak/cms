<?php
namespace Controller\User;

use Auth\Auth;
use FrontController\Controller as FrontController;
use App\Resource\Server;
use Auth\HashPass;
use DataBase\Command\Command;
use Entity\Users;
use Ignaszak\Registry\RegistryFactory;

class UserLoginController extends FrontController
{

    /**
     *
     * @var \Entity\Users
     */
    private $userEntity = null;

    /**
     *
     * @var string
     */
    private $remember = '';

    public function run()
    {
        if ($this->registry->get('user')->isUserLoggedIn()) {
            Server::headerLocationReferer();
        }

        $command = new Command(new Users());
        $login = $this->http->request->get('userLogin');
        if ($this->isEmail($login)) {
            $command->setEmail($login);
        } else {
            $command->setLogin($login);
        }
        $command->setPassword($this->http->request->get('userPassword'));
        $auth = new Auth($command);
        if ($this->http->request->get('userRemember', null)) {
            $auth->remember();
        }
        $auth->login();
        var_dump($auth->isUserLoggedIn());
        var_dump($auth->getUser());
        /*$userId = $this->getUserId();

        if ($userId === 0) {
            Server::setReferData([
                'form' => 'login',
                'error' => ['valid'.ucfirst($this->column).'_or_password' => 1]
            ]);
            Server::headerLocationReferer();
        } else {
            $controller = new Command(new Users());
            $controller->find($userId)
                ->setLogDate(new \DateTime('now'))
                ->update();

            $this->setSession();
            Server::headerLocationReferer();
        }*/
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
}
