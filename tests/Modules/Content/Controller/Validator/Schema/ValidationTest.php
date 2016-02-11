<?php
namespace Test\Modules\Content\Controller\Validator\Schema;

use Content\Controller\Validator\Schema\Validation;

class ValidationTest extends \PHPUnit_Framework_TestCase
{

    private $_validation;

    public function setUp()
    {
        $this->_validation = new Validation();
    }

    public function testCategory()
    {
        $validCategory = $this->_validation->category(new \Entity\Categories());
        $this->assertTrue($validCategory);
    }

    public function testAuthor()
    {
        $validAuthor = $this->_validation->author(new \Entity\Users());
        $this->assertTrue($validAuthor);
    }

    public function testDate()
    {
        $validDate = $this->_validation->date(new \DateTime());
        $this->assertTrue($validDate);
    }

    public function testTitle()
    {
        $title = "New Title";
        $validTitle = $this->_validation->title($title);
        $this->assertTrue($validTitle);
    }

    public function testAlias()
    {
        $alias = "new-title";
        $validAlias = $this->_validation->alias($alias);
        $this->assertTrue($validAlias);
    }

    public function testContent()
    {
        $content = "New Content";
        $validContent = $this->_validation->content($content);
        $this->assertTrue($validContent);
    }
}
