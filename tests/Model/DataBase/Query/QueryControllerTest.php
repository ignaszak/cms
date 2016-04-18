<?php
namespace Test\Model\DataBase\Query;

use Test\Mock\MockDoctrine;
use Test\Mock\MockConf;
use Test\Mock\MockTest;
use DataBase\Query\QueryController;
use Test\Mock\MockHttp;

class QueryControllerTest extends \PHPUnit_Framework_TestCase
{

    private $_queryController;

    public function setUp()
    {
        MockHttp::routeGroup('admin');
        MockHttp::routeSet(['alias' => 'route']);
        MockHttp::run();
        MockConf::run();
        MockDoctrine::queryBuilderResult([null]); // Symulate no result
        $entity = $this->getMockBuilder('Entity\Posts')->getMock();
        $entity->method('getPublic');
        $this->_queryController = new QueryController(get_class($entity));
    }

    public function tearDown()
    {
        MockDoctrine::clear();
    }

    public function testSelectOnlyPublicPostsByStatusHandler()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('createQueryBuilder');
        $em->shouldReceive('andwhere')->once();
        MockTest::inject($this->_queryController, 'query', $em);
        $this->_queryController->status('public');
        MockTest::callMockMethod($this->_queryController, 'statusHandler');
    }

    public function testSelectEditPostsByStatusHandler()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('createQueryBuilder');
        $em->shouldReceive('andwhere')->once();
        MockTest::inject($this->_queryController, 'query', $em);
        $this->_queryController->status('edit');
        MockTest::callMockMethod($this->_queryController, 'statusHandler');
    }

    public function testSelectAllPostsByStatusHandler()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('createQueryBuilder');
        $em->shouldReceive('andwhere')->never();
        MockTest::inject($this->_queryController, 'query', $em);
        $this->_queryController->status('all');
        MockTest::callMockMethod($this->_queryController, 'statusHandler');
    }

    public function testAliasNotEmptyAndResultIsNotForced()
    {
        $method = MockTest::callMockMethod(
            $this->_queryController,
            'isAliasEmptyOrIsResultForced'
        );
        $this->assertFalse($method);
    }

    public function testAliasNotEmptyAndResultIsForced()
    {
        $this->_queryController->force();
        $method = MockTest::callMockMethod(
            $this->_queryController,
            'isAliasEmptyOrIsResultForced'
        );
        $this->assertTrue($method);
    }

    public function testSetNoLimit()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('setMaxResults')->never();
        MockTest::inject($this->_queryController, 'query', $em);
        MockTest::callMockMethod($this->_queryController, 'setLimit');
    }

    public function testSetLimit()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('setMaxResults')->once();
        MockTest::inject($this->_queryController, 'query', $em);
        $anyLimit = 1;
        $this->_queryController->limit($anyLimit);
        MockTest::callMockMethod($this->_queryController, 'setLimit');
    }
}
