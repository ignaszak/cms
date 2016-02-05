<?php
namespace Controller\User;

use FrontController\Controller;
use System\Server;
use UserAuth\HashPass;
use Content\Controller\Factory;
use Content\Controller\UserController;
use Ignaszak\Registry\RegistryFactory;

class UserSaveController extends Controller
{

    /**
     *
     * @var \Entity\Users
     */
    private $_userEntity;

    private $_user;

    public function run()
    {
        $this->checkIfUserIsLoggedAndSetUserSession();

        $this->login = $_POST['userLogin'];
        $this->password = $_POST['userPassword'];
        $this->remember = @$_POST['userRemember'];

        $userId = $this->getUserId();

        if ($userId === 0) {
            Server::setReferData([
                'form' => 'login',
                'error' => ['incorrectLoginOrPassword' => 1]
            ]);
            Server::headerLocationReferer();
        } else {
            $controller = new Factory(new UserController());
            $controller->find($userId)
                ->setLogDate(new \DateTime('now'))
                ->update();

            $this->setSession();
            Server::headerLocationReferer();
        }
    }

    private function checkIfUserIsLoggedAndSetUserSession()
    {
        $_user = RegistryFactory::start()->get('user');
        if (! $_user->isUserLoggedIn()) {
            Server::headerLocationReferer();
        }
        $this->_user = $_user->getUserSession();
    }

    /**
     *
     * @return integer
     */
    private function getUserId(): int
    {
        $this->query()
            ->setContent('user')
            ->findBy($this->isEmail($this->login) ? 'email' : 'login', $this->login)
            ->force()
            ->paginate(false);
        $result = $this->query()->getContent();

        if (count($result) === 1 && HashPass::verifyPassword($this->password, $result[0]->getPassword())) {
            $this->_userEntity = $result[0];
            return $this->_userEntity->getId();
        }
        return 0;
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

    private function setSession()
    {
        if ($this->remember) {
            RegistryFactory::start('cookie')->set('userSession', $this->_userEntity);
        } else {
            RegistryFactory::start('session')->set('userSession', $this->_userEntity);
        }
    }
}
