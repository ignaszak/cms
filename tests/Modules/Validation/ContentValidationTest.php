<?php

namespace Test\Modules\Validation;

use Validation\ContentValidation;

class ContentValidationTest extends \PHPUnit_Framework_TestCase
{

    private $_contentValidation;

    public function setUp()
    {
        $this->_contentValidation = new ContentValidation;
    }

    public function testValidCategory()
    {
        $validCategory = $this->_contentValidation->validCategory(new \Entity\Categories);
        $this->assertTrue($validCategory);
    }

    public function testValidAuthor()
    {
        $validAuthor = $this->_contentValidation->validAuthor(new \Entity\Users);
        $this->assertTrue($validAuthor);
    }

    public function testValidDate()
    {
        $validDate = $this->_contentValidation->validDate(new \DateTime);
        $this->assertTrue($validDate);
    }

    public function testValidTitle()
    {
        $title = "New Title";
        $validTitle = $this->_contentValidation->validTitle($title);
        $this->assertTrue($validTitle);

    }

    public function testValidAlias()
    {
        $alias = "new-title";
        $validAlias = $this->_contentValidation->validAlias($alias);
        $this->assertTrue($validAlias);
    }

    public function testValidContent()
    {
        $content = "New Content";
        $validContent = $this->_contentValidation->validContent($content);
        $this->assertTrue($validContent);
    }

}
