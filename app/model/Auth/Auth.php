<?php
declare(strict_types=1);

namespace Auth;

use Conf\DB\DBDoctrine;
use DataBase\Command\Command;
use DataBase\Query\Query;
use Entity\Users;

class Auth
{

    /**
     * @var Query
     */
    private $query = null;

    /**
     * @var Users
     */
    private $user = null;

    /**
     * @var int
     */
    private $userId = 0;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        $this->query = new Query();
        $this->userId = $this->getLoggedUserId();
        $this->user = $this->getUserEntityBy('id', $this->userId);
    }

    /**
     * @param Command $command
     * @return AuthCommand
     */
    public function command(Command $command): AuthCommand
    {
        return new AuthCommand($command);
    }

    /**
     * @return Users
     */
    public function getUser(): Users
    {
        return $this->user ?? new Users();
    }

    /**
     * @return bool
     */
    public function isUserLoggedIn(): bool
    {
        return $this->userId !== 0;
    }

    public function logout()
    {
        setcookie('userToken', '', time() -3600, '/');
        $_SESSION['userToken'] = '';
    }

    /**
     * @return int
     */
    private function getLoggedUserId(): int
    {
        $em = DBDoctrine::em();
        $query = "SELECT `user_id` FROM `users_session`
            WHERE `token` = :s OR `token` = :c";
        $stmt = $em->getConnection()->prepare($query);
        $stmt->execute(
            [
                's' => $_SESSION['userToken'] ?? '',
                'c' => $_COOKIE['userToken'] ?? ''
            ]
        );
        return (int) $stmt->fetch()['user_id'] ?? 0;
    }

    /**
     * @param string $by
     * @param mixed $value
     * @return Users
     */
    private function getUserEntityBy(string $by, $value): Users
    {
        $this->query->setQuery('user')->findBy($by, $value);
        return $this->query->getStaticQuery()[0] ?? new Users();
    }
}
