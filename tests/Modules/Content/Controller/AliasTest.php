<?php

namespace Test\Modules\Content\Controller;

use Test\Mock\MockTest;
use Content\Controller\Alias;
use Test\Init\InitDoctrine;

class AliasTest extends \PHPUnit_Framework_TestCase
{

    private $_alias;

    public function setUp()
    {
        $this->_alias = new Alias(new \Entity\Posts);
    }
    
    public function tearDown()
    {
        InitDoctrine::clear();
    }

    public function testIfAliasIsCorrectCreatedFromString()
    {
        $string = "Any String @ # % ć Ż ą";
        $alias = "any-string-c-z-a";
        $createAliasFromString = MockTest::callMockMethod(
            $this->_alias,
            'createAliasFromString',
            array($string)
        );
        $this->assertEquals($alias, $createAliasFromString);
    }

    public function testAliasExistsInDB()
    {
        $alias = 'new-post';
        InitDoctrine::getRepositoryResult(array($alias));
        $aliasNotExistsInDB = MockTest::callMockMethod(
            $this->_alias,
            'isAliasNotExistsInDB',
            array($alias)
        );
        $this->assertFalse($aliasNotExistsInDB);
    }

    public function testGetAlias()
    {
        $string = 'New Post';
        $alias = $this->_alias->getAlias($string);
        InitDoctrine::getRepositoryResult(array($alias));
        $aliasNotExistsInDB = MockTest::callMockMethod(
            $this->_alias,
            'isAliasNotExistsInDB',
            array($alias)
        );
        $this->assertTrue($aliasNotExistsInDB);
    }

}
