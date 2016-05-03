<?php
namespace View\Extension;

use Ignaszak\Registry\RegistryFactory;

class User
{

    /**
     *
     * @var \UserAuth\User
     */
    private $user = null;

    public function __construct()
    {
        $this->user = RegistryFactory::start()->get('user');
    }

    /**
     *
     * @return boolean
     */
    public function isUserLoggedIn(): bool
    {
        return $this->user->isUserLoggedIn();
    }

    /**
     *
     * @return integer
     */
    public function getUserId(): int
    {
        return $this->user->getUserSession()->getId();
    }

    /**
     *
     * @return string
     */
    public function getUserLogin(): string
    {
        return $this->user->getUserSession()->getLogin();
    }

    /**
     *
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->user->getUserSession()->getEmail();
    }

    /**
     *
     * @param string $format
     * @return DateTime|string
     */
    public function getUserRegistrationDate(string $format = '')
    {
        return $this->user->getUserSession()->getRegDate($format);
    }

    /**
     *
     * @param string $format
     * @return DateTime|string
     */
    public function getUserLoginDate(string $format = '')
    {
        return $this->user->getUserSession()->getLogDate($format);
    }

    /**
     *
     * @return string
     */
    public function getUserRole(): string
    {
        return $this->user->getUserSession()->getRole();
    }
}
