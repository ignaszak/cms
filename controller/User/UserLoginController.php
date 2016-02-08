<?php
namespace Controller\User;

use FrontController\Controller as FrontController;
use System\Server;
use UserAuth\HashPass;
use Content\Controller\Controller;
use Entity\Users;
use Ignaszak\Registry\RegistryFactory;

class UserLoginController extends FrontController
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
    private $login;

    /**
     *
     * @var string
     */
    private $password;

    /**
     *
     * @var string
     */
    private $remember;

    public function run()
    {
        $_user = RegistryFactory::start()->get('user');
        if ($_user->isUserLoggedIn()) {
            Server::headerLocationReferer();
        }

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
            $controller = new Controller(new Users());
            $controller->find($userId)
                ->setLogDate(new \DateTime('now'))
                ->update();

            $this->setSession();
            Server::headerLocationReferer();
        }
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
