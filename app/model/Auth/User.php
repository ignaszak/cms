<?php
namespace Auth;

use Conf\DB\DBDoctrine;
use Ignaszak\Registry\RegistryFactory;

class User
{

    /**
     *
     * @var \Entity\Users
     */
    private $userSession = null;

    public function __construct()
    {
        $this->catchUserSession();
    }

    /**
     *
     * @return boolean
     */
    public function isUserLoggedIn(): bool
    {
        return isset($this->userSession) && DBDoctrine::em()
            ->getRepository('Entity\Users')->findBy([
                'login' => $this->userSession->getLogin(),
                'password' => $this->userSession->getPassword()
            ]);
    }

    /**
     *
     * @return \Entity\Users
     */
    public function getUser(): \Entity\Users
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
