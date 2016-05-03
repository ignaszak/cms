<?php
namespace Controller\User;

use FrontController\Controller as FrontController;
use App\Resource\Server;
use UserAuth\HashPass;
use DataBase\Controller\Controller;
use Entity\Users;
use Ignaszak\Registry\RegistryFactory;

class UserSaveController extends FrontController
{

    public function run()
    {
        $user = $this->registry->get('user');
        $this->checkIfUserIsLogged($user);

        $userId = $user->getUserSession()->getId();
        $controller = new Controller(new Users());
        $controller->find($userId);

        if (!empty($this->http->request->get('userPassword'))) {
            Server::setReferData(['form' => 'accountPassword']);
            $this->savePassword($controller);
        } else {
            Server::setReferData(['form' => 'accountData']);
            $this->saveData($controller);
        }

        $this->reloadUserSession($controller->entity());

        Server::setReferData(['accountSuccess' => 1]);
        Server::headerLocationReferer();
    }

    /**
     *
     * @param \UserAuth\User $user
     */
    private function checkIfUserIsLogged(\UserAuth\User $user)
    {
        if (! $user->isUserLoggedIn()) {
            Server::headerLocationReferer();
        }
    }

    /**
     *
     * @param Controller $controller
     */
    private function savePassword(Controller $controller)
    {
        $hash = $controller->entity()->getPassword();
        if (! HashPass::verifyPassword(
            $this->http->request->get('userPassword'),
            $hash
        )
        ) {
            Server::setReferData([
                'error' => ['validPassword' => 1]
            ]);
            Server::headerLocationReferer();
        } else {
            $controller->setPassword($this->http->request->get('userNewPassword'))
                ->update(['password' => []]);
        }
    }

    /**
     *
     * @param Controller $controller
     */
    private function saveData(Controller $controller)
    {
        $controller->setEmail($this->http->request->get('userEmail'))
            ->update([
                'email' => [
                    'unique' => [$controller->entity()->getEmail()]
                ]
            ]);
    }

    /**
     *
     * @param \Entity\Users $userEntity
     */
    private function reloadUserSession(\Entity\Users $userEntity)
    {
        if (RegistryFactory::start('session')->get('userSession')) {
            RegistryFactory::start('session')->set('userSession', $userEntity);
        } else {
            RegistryFactory::start('cookie')->set('userSession', $userEntity);
        }
    }
}
