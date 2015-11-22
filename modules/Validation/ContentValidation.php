<?php

namespace Validation;

class ContentValidation extends Validator
{

    public function validCategoryId($categoryId)
    {
        return $this->validId($categoryId);
    }

    public function validAuthorId($authorId)
    {
        return $this->validId($authorId);
    }

    public function validDate($date)
    {
        return $date instanceof \DateTime;
    }

    public function validTitle($title)
    {
        return parent::$_auraFilter->validate($title, 'strlenMin', 1)
            && parent::$_auraFilter->sanitize($title, 'string');
    }

    public function validAlias($alias)
    {
        return parent::$_auraFilter->validate($alias, 'strlenMin', 1)
        && parent::$_auraFilter->sanitize($alias, 'string');
    }

    public function validContent($content)
    {
        return parent::$_auraFilter->validate($content, 'strlenMin', 1)
            && parent::$_auraFilter->sanitize($content, 'string');
    }

    private function validId($id)
    {
        return is_numeric($id);
    }

}
