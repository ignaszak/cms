<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 02.07.16
 * Time: 16:59
 */

namespace Auth;

use DataBase\Command\Command;
use DataBase\Query\Query;
use Entity\Users;

class AuthCommand
{

    /**
     * @var Query
     */
    private $query = null;

    /**
     * @var Command
     */
    private $command = null;

    /**
     * @var bool
     */
    private $remember = false;

    /**
     * AuthCommand constructor.
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->query = new Query();
        $this->command = $command;
    }

    public function register()
    {
        $dateTime = new \DateTime('now');
        $this->command->setRegDate($dateTime)
            ->setLogDate($dateTime)
            ->insert(
                [
                    'login' => ['unique'],
                    'email' => ['unique'],
                    'password' => []
                ]
            );
    }

    public function login()
    {
        if (!empty($this->command->getEmail())) {
            $user = $this->getUserEntityBy(
                'email',
                $this->command->getEmail()
            );
        } else {
            $user = $this->getUserEntityBy(
                'login',
                $this->command->getLogin()
            );
        }
        if (HashPass::verifyPassword(
            $this->command->getPassword(),
            $user->getPassword()
        )) {
            $token = $this->createToken();
            $em = $this->command->em();
            $query = "INSERT INTO `users_session`
                (`id`, `user_id`, `token`, `log_date`, `ip`, `key`)
                VALUES (null, :id, :token, :dateTime, :ip, :key)
                ON DUPLICATE KEY UPDATE token = VALUES(token)"; // TODO create index
            $stmt = $em->getConnection()->prepare($query);
            $stmt->execute(
                [
                    'id' => $user->getId(),
                    'token' => $token,
                    'dateTime' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'key' => md5($user->getId() . '.' . $_SERVER['REMOTE_ADDR'])
                ]
            );
            if ($this->remember) {
                setcookie('userToken', $token, time() + 60*60*24*7, '/');
            } else {
                $_SESSION['userToken'] = $token;
            }
        }
    }

    public function remember()
    {
        $this->remember = true;
    }

    /**
     * @return string
     */
    private function createToken(): string
    {
        return md5((string) time());
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
