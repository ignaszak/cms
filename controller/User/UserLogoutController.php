<?php
namespace Controller\User;

use FrontController\Controller as FrontController;
use System\Server;
use Ignaszak\Registry\RegistryFactory;

class UserLogoutController extends FrontController
{

    public function run()
    {
        $_user = RegistryFactory::start()->get('user');
        if ($_user->isUserLoggedIn()) {
            RegistryFactory::start('cookie')->remove('userSession');
            RegistryFactory::start('session')->remove('userSession');
        }
        Server::setReferData([
            'search' => Server::getReferData()['search']
        ]);
        Server::headerLocationReferer();
    }
}
