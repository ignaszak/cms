<?php

namespace Validation;

class PostValidation extends Validator
{

    public function validPostTitle($postTitle)
    {
        return parent::$_auraFilter->validate($postTitle, 'strlenMin', 1)
            && parent::$_auraFilter->sanitize($postTitle, 'string');
    }

    public function validPostContent($postContent)
    {
        return parent::$_auraFilter->validate($postContent, 'strlenMin', 1)
            && parent::$_auraFilter->sanitize($postContent, 'string');
    }

}
