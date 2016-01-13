<?php

namespace Validation;

use Ignaszak\Registry\RegistryFactory;

class ContentValidation extends Validator
{

    /**
     * @param \Entity\Categories $_category
     * @return boolean
     */
    public function validCategory($_category): bool
    {
        return $this->validObject($_category, 'category');
    }

    /**
     * @param \Entity\Users $_author
     * @return boolean
     */
    public function validAuthor($_author): bool
    {
        return $this->validObject($_author, 'author');
    }

    /**
     * @param \DateTime $_date
     * @return boolean
     */
    public function validDate($_date): bool
    {
        return $_date instanceof \DateTime;
    }

    /**
     * @param string $title
     * @return boolean
     */
    public function validTitle($title): bool
    {
        return parent::$_auraFilter->validate($title, 'strlenMin', 1)
            && parent::$_auraFilter->sanitize($title, 'string');
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function validName($name): bool
    {
        return $this->validTitle($name);
    }

    /**
     * @param string $position
     * @return boolean
     */
    public function validPosition($position): bool
    {
        return $this->validTitle($position);
    }

    /**
     * @param string $alias
     * @return boolean
     */
    public function validAlias($alias): bool
    {
        return parent::$_auraFilter->validate($alias, 'strlenMin', 1)
        && parent::$_auraFilter->sanitize($alias, 'string');
    }

    /**
     * @param string $content
     * @return boolean
     */
    public function validContent($content): bool
    {
        return parent::$_auraFilter->validate($content, 'strlenMin', 1)
            && parent::$_auraFilter->sanitize($content, 'string');
    }

    public function validLogin(string $content): bool
    {
        return true;
    }

    public function validEmail(string $content): bool
    {
        return true;
    }

    public function validPassword(string $content): bool
    {
        return true;
    }

    public function validRegDate($content): bool
    {
        return true;
    }

    public function validLogDate($content): bool
    {
        return true;
    }

    public function validRole(string $content): bool
    {
        return true;
    }

    /**
     * @param \Entity $_object
     * @param string $name
     * @return boolean
     */
    private function validObject($_object, $name): bool
    {
        $_entityController = RegistryFactory::start()
            ->register('Entity\Controller\EntityController');
        $class = $_entityController->getEntity($name);
        return $_object instanceof $class;
    }

}
