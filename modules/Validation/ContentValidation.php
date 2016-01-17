<?php

namespace Validation;

use Ignaszak\Registry\RegistryFactory;
use Respect\Validation\Validator as V;

class ContentValidation
{

    /**
     * @param \Entity\Categories $_category
     * @return boolean
     */
    public function validCategory($_category): bool
    {
        return $this->validEntityController($_category, 'category');
    }

    /**
     * @param \Entity\Users $_author
     * @return boolean
     */
    public function validAuthor($_author): bool
    {
        return $this->validEntityController($_author, 'author');
    }

    /**
     * @param \DateTime $_date
     * @return boolean
     */
    public function validDate($_date): bool
    {
        return V::instance('DateTime')->validate($_date);
    }

    /**
     * Post, category and page title
     *
     * @param string $title
     * @return boolean
     */
    public function validTitle($title): bool
    {
        return V::stringType()->length(5, null)->validate($title);
    }

    /**
     * Menu name
     *
     * @param string $name
     * @return boolean
     */
    public function validName($name): bool
    {
        return V::stringType()->length(2, null)->validate($name);
    }

    /**
     * Menu position
     *
     * @param string $position
     * @return boolean
     */
    public function validPosition($position): bool
    {
        return V::slug()->validate($position);
    }

    /**
     * @param string $alias
     * @return boolean
     */
    public function validAlias($alias): bool
    {
        return V::slug()->validate($alias);
    }

    /**
     * @param string $content
     * @return boolean
     */
    public function validContent($content): bool
    {
        return V::stringType()->length(5, null)->validate($content);
    }

    /**
     * @param string $login
     * @return boolean
     */
    public function validLogin($login): bool
    {
        return V::alnum('_')->noWhitespace()->length(2, null)->validate($login);
    }

    /**
     * @param string $email
     * @return boolean
     */
    public function validEmail($email): bool
    {
        return V::email()->validate($email);
    }

    /**
     * @param string $password
     * @return boolean
     */
    public function validPassword($password): bool
    {
        return V::alnum()->noWhitespace()->length(8, null)->validate($password);
    }

    /**
     * @param \DateTime $_regDate
     * @return boolean
     */
    public function validRegDate($_regDate): bool
    {
        return V::instance('DateTime')->validate($_regDate);
    }

    /**
     * @param \DateTime $_logDate
     * @return boolean
     */
    public function validLogDate($_logDate): bool
    {
        return V::instance('DateTime')->validate($_logDate);
    }

    /**
     * @param string $role
     * @return boolean
     */
    public function validRole($role): bool
    {
        return V::in(['admin', 'moderator', 'user'])->validate($role);
    }

    /**
     * @param \Entity $_object
     * @param string $name
     * @return boolean
     */
    private function validEntityController($_object, $name): bool
    {
        $_entityController = RegistryFactory::start()
            ->register('Entity\Controller\EntityController');
        $class = $_entityController->getEntity($name);
        return $_object instanceof $class;
    }

}
