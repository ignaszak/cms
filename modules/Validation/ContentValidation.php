<?php

namespace Validation;

use Entity\EntityController;

class ContentValidation extends Validator
{

    /**
     * @param \Entity\Categories $_category
     * @return boolean
     */
    public function validCategory($_category)
    {
        return $this->validObject($_category, 'category');
    }

    /**
     * @param \Entity\Users $_author
     * @return boolean
     */
    public function validAuthor($_author)
    {
        return $this->validObject($_author, 'author');
    }

    /**
     * @param \DateTime $_date
     * @return boolean
     */
    public function validDate($_date)
    {
        return $_date instanceof \DateTime;
    }

    /**
     * @param string $title
     * @return boolean
     */
    public function validTitle($title)
    {
        return parent::$_auraFilter->validate($title, 'strlenMin', 1)
            && parent::$_auraFilter->sanitize($title, 'string');
    }

    /**
     * @param string $alias
     * @return boolean
     */
    public function validAlias($alias)
    {
        return parent::$_auraFilter->validate($alias, 'strlenMin', 1)
        && parent::$_auraFilter->sanitize($alias, 'string');
    }

    /**
     * @param string $content
     * @return boolean
     */
    public function validContent($content)
    {
        return parent::$_auraFilter->validate($content, 'strlenMin', 1)
            && parent::$_auraFilter->sanitize($content, 'string');
    }

    /**
     * @param \Entity $_object
     * @param string $name
     * @return boolean
     */
    private function validObject($_object, $name)
    {
        $class = EntityController::instance()->getEntityByName($name);
        return $_object instanceof $class;
    }

}
