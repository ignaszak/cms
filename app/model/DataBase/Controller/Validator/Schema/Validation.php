<?php
namespace DataBase\Controller\Validator\Schema;

use Ignaszak\Registry\RegistryFactory;
use Respect\Validation\Validator as V;

class Validation
{

    /**
     *
     * @param \Entity\Categories $_category
     * @return boolean
     */
    public function category($_category): bool
    {
        return $this->validEntityController($_category, 'category');
    }

    /**
     *
     * @param \Entity\Users $_author
     * @return boolean
     */
    public function author($_author): bool
    {
        return $this->validEntityController($_author, 'author');
    }

    /**
     *
     * @param \DateTime $_date
     * @return boolean
     */
    public function date($_date): bool
    {
        return V::instance('DateTime')->validate($_date);
    }

    /**
     * Post, category and page title
     *
     * @param string $title
     * @return boolean
     */
    public function title($title): bool
    {
        return V::stringType()->length(5, null)->validate($title);
    }

    /**
     * Menu name
     *
     * @param string $name
     * @return boolean
     */
    public function name($name): bool
    {
        return V::stringType()->length(2, null)->validate($name);
    }

    /**
     * Menu position
     *
     * @param string $position
     * @return boolean
     */
    public function position($position): bool
    {
        return V::slug()->validate($position);
    }

    /**
     *
     * @param string $alias
     * @return boolean
     */
    public function alias($alias): bool
    {
        return V::slug()->validate($alias);
    }

    /**
     *
     * @param string $content
     * @return boolean
     */
    public function content($content): bool
    {
        return V::stringType()->length(5, null)->validate($content);
    }

    /**
     *
     * @param string $login
     * @return boolean
     */
    public function login($login): bool
    {
        return V::alnum('_')->noWhitespace()
            ->length(2, null)
            ->validate($login);
    }

    /**
     *
     * @param string $email
     * @return boolean
     */
    public function email($email): bool
    {
        return V::email()->validate($email);
    }

    /**
     *
     * @param string $password
     * @return boolean
     */
    public function password($password): bool
    {
        return V::alnum()->noWhitespace()
            ->length(8, null)
            ->validate($password);
    }

    /**
     *
     * @param \DateTime $_regDate
     * @return boolean
     */
    public function regDate($_regDate): bool
    {
        return V::instance('DateTime')->validate($_regDate);
    }

    /**
     *
     * @param \DateTime $_logDate
     * @return boolean
     */
    public function logDate($_logDate): bool
    {
        return V::instance('DateTime')->validate($_logDate);
    }

    /**
     *
     * @param string $role
     * @return boolean
     */
    public function role($role): bool
    {
        return V::in([
            'admin',
            'moderator',
            'user'
        ])->validate($role);
    }

    /**
     *
     * @param \Entity $_object
     * @param string $name
     * @return boolean
     */
    private function validEntityController($_object, $name): bool
    {
        $_entityController = RegistryFactory::start()->register('Entity\Controller\EntityController');
        $class = $_entityController->getEntity($name);
        return $_object instanceof $class;
    }
}
