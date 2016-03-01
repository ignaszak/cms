<?php
namespace Test\Model\DataBase\Controller;

use Test\Mock\MockTest;
use Test\Mock\MockDoctrine;
use DataBase\Controller\Alias;

class AliasTest extends \PHPUnit_Framework_TestCase
{

    private $_alias;

    public function setUp()
    {
        $this->_alias = new Alias(new \Entity\Posts());
    }

    public function tearDown()
    {
        MockDoctrine::clear();
    }

    public function testIfAliasIsCorrectCreatedFromString()
    {
        $string = "Any String @ # % ć Ż ą";
        $alias = "any-string-c-z-a";
        $createAliasFromString = MockTest::callMockMethod(
            $this->_alias,
            'createAliasFromString',
            [$string]
        );
        $this->assertEquals($alias, $createAliasFromString);
    }

    public function testAliasExistsInDB()
    {
        $alias = 'new-post';
        MockDoctrine::getRepositoryResult([$alias]);
        $this->_alias = new Alias(new \Entity\Posts());
        $aliasNotExistsInDB = MockTest::callMockMethod(
            $this->_alias,
            'isAliasNotExistsInDB',
            [$alias]
        );
        $this->assertFalse($aliasNotExistsInDB);
    }

    public function testGetAliasIfAliasAlredyExists()
    {
        $existingAlias = 'alias';
        $entity = \Mockery::mock('Entity\Posts');
        $entity->shouldReceive('getAlias')->andReturnValues([$existingAlias]);
        $this->_alias = new Alias($entity);
        $alias = $this->_alias->getAlias($existingAlias);

        $this->assertEquals($alias, $existingAlias);
    }

    public function testGetAliasIfAliasNotExists()
    {
        $string = 'AnyString';
        $entity = \Mockery::mock('Entity\Posts');
        $entity->shouldReceive('getAlias')->andReturnValues([]);
        MockDoctrine::getRepositoryResult([]);
        $this->_alias = new Alias($entity);
        $alias = $this->_alias->getAlias($string);
        $this->assertEquals('anystring', $alias);
    }
}
