<?php
namespace View\Extension;

use Auth\Auth;
use Ignaszak\Registry\RegistryFactory;

class User
{

    /**
     *
     * @var \Auth\User
     */
    private $auth = null;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    /**
     *
     * @return boolean
     */
    public function isUserLoggedIn(): bool
    {
        return $this->auth->isUserLoggedIn();
    }

    /**
     *
     * @return integer
     */
    public function getUserId(): int
    {
        return $this->auth->getUser()->getId();
    }

    /**
     *
     * @return string
     */
    public function getUserLogin(): string
    {
        return $this->auth->getUser()->getLogin();
    }

    /**
     *
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->auth->getUser()->getEmail();
    }

    /**
     *
     * @param string $format
     * @return DateTime|string
     */
    public function getUserRegistrationDate(string $format = '')
    {
        return $this->auth->getUser()->getRegDate($format);
    }

    /**
     *
     * @param string $format
     * @return DateTime|string
     */
    public function getUserLoginDate(string $format = '')
    {
        return $this->auth->getUser()->getLogDate($format);
    }

    /**
     *
     * @return string
     */
    public function getUserRole(): string
    {
        return $this->auth->getUser()->getRole();
    }
}
