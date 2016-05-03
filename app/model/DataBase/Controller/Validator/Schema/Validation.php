<?php
namespace DataBase\Controller\Validator\Schema;

use Ignaszak\Registry\RegistryFactory;
use Respect\Validation\Validator as V;

class Validation
{

    /**
     *
     * @param \Entity\Categories $category
     * @return boolean
     */
    public function category($category): bool
    {
        return $this->validEntityController($category, 'category');
    }

    /**
     *
     * @param \Entity\Users $author
     * @return boolean
     */
    public function author($author): bool
    {
        return $this->validEntityController($author, 'author');
    }

    /**
     *
     * @param \DateTime $date
     * @return boolean
     */
    public function date($date): bool
    {
        return V::instance('DateTime')->validate($date);
    }

    /**
     * Post, category and page title
     *
     * @param string $title
     * @return boolean
     */
    public function title($title): bool
    {
        return V::stringType()->length(1, null)->validate($title);
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
        return V::stringType()->length(1, null)->validate($content);
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
     * @param \DateTime $regDate
     * @return boolean
     */
    public function regDate($regDate): bool
    {
        return V::instance('DateTime')->validate($regDate);
    }

    /**
     *
     * @param \DateTime $logDate
     * @return boolean
     */
    public function logDate($logDate): bool
    {
        return V::instance('DateTime')->validate($logDate);
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
     * @param \Entity $object
     * @param string $name
     * @return boolean
     */
    private function validEntityController($object, $name): bool
    {
        $entityController = RegistryFactory::start()->register('Entity\Controller\EntityController');
        $class = $entityController->getEntity($name);
        return $object instanceof $class;
    }
}
