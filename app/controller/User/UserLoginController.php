<?php
namespace Controller\User;

use App\Resource\Server;
use FrontController\Controller as FrontController;
use DataBase\Command\Command;
use Entity\Users;

class UserLoginController extends FrontController
{

    public function run()
    {

        if ($this->auth->isUserLoggedIn()) {
            Server::headerLocationReferer();
        }

        $command = new Command(new Users());
        $login = $this->http->request->get('userLogin');
        if ($this->isEmail($login)) {
            $command->setEmail($login);
            $column  = 'email';
        } else {
            $command->setLogin($login);
            $column = 'login';
        }
        $command->setPassword($this->http->request->get('userPassword'));
        $authCommand = $this->auth->command($command);

        if ($this->http->request->get('userRemember', null)) {
            $authCommand->remember();
        }

        $authCommand->login();

        if (! $this->auth->isUserLoggedIn()) {
            Server::setReferData(
                [
                    'form' => 'login',
                    'error' => ['valid'.ucfirst($column).'_or_password' => 1]
                ]
            );
        }

        Server::headerLocationReferer();
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
