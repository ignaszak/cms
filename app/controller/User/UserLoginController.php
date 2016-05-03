<?php
namespace Controller\User;

use FrontController\Controller as FrontController;
use App\Resource\Server;
use UserAuth\HashPass;
use DataBase\Controller\Controller;
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
    private $login = '';

    /**
     *
     * @var string
     */
    private $column = '';

    /**
     *
     * @var string
     */
    private $password = '';

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

        $this->login = $this->http->request->get('userLogin');
        $this->column = $this->isEmail($this->login) ? 'email' : 'login';
        $this->password = $this->http->request->get('userPassword');
        $this->remember = $this->http->request->get('userRemember', null);

        $userId = $this->getUserId();

        if ($userId === 0) {
            Server::setReferData([
                'form' => 'login',
                'error' => ['valid'.ucfirst($this->column).'_or_password' => 1]
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
        $this->query->setQuery('user')
            ->findBy($this->column, $this->login);
        $result = $this->query->getStaticQuery();

        if (count($result) === 1 &&
            HashPass::verifyPassword($this->password, $result[0]->getPassword())) {
            $this->userEntity = $result[0];
            return $this->userEntity->getId();
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
            RegistryFactory::start('cookie')->set('userSession', $this->userEntity);
        } else {
            RegistryFactory::start('session')->set('userSession', $this->userEntity);
        }
    }
}
