<?php
namespace Controller\User;

use FrontController\Controller as FrontController;
use App\Resource\Server;
use Ignaszak\Registry\RegistryFactory;

class UserLogoutController extends FrontController
{

    public function run()
    {
        if ($this->auth->isUserLoggedIn()) {
            $this->auth->logout();
        }
        Server::setReferData([
            'search' => Server::getReferData()['search']
        ]);
        Server::headerLocationReferer();
    }
}
