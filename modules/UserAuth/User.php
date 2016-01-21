<?php
namespace UserAuth;

use Conf\DB\DBDoctrine;
use Ignaszak\Registry\RegistryFactory;

class User
{

    /**
     *
     * @var \Entity\Users
     */
    private $userSession;

    public function __construct()
    {
        $this->catchUserSession();
    }

    public function isUserLoggedIn()
    {
        return isset($this->userSession) && DBDoctrine::em()->getRepository('Entity\Users')->findBy(array(
            'login' => $this->userSession->getLogin(),
            'password' => $this->userSession->getPassword()
        ));
    }

    public function getUserSession()
    {
        return $this->userSession;
    }

    public function catchUserSession()
    {
        $session = RegistryFactory::start('session')->get('userSession');
        $cookie = RegistryFactory::start('cookie')->get('userSession');
        
        if ($session instanceof \Entity\Users) {
            $this->userSession = $session;
        } elseif ($cookie instanceof \Entity\Users) {
            $this->userSession = $cookie;
        }
    }
}
