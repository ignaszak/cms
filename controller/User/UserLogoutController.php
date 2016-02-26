<?php
namespace Controller\User;

use FrontController\Controller as FrontController;
use App\Resource\Server;
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
