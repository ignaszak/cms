<?php
namespace Test\Model\Content\Query;

use Content\Query\ContentQueryController;
use Test\Mock\MockDoctrine;
use Test\Mock\MockConf;
use Test\Mock\MockRouter;
use Test\Mock\MockTest;

class ContentQueryControllerTest extends \PHPUnit_Framework_TestCase
{

    private $_contentQueryController;

    public function setUp()
    {
        MockRouter::start('route');
        MockRouter::add('admin', '{alias:route}');
        MockRouter::run();
        MockConf::run();
        MockDoctrine::queryBuilderResult(array(
            null
        )); // Symulate no result
        $entity = $this->getMockBuilder('Entity\Posts')->getMock();
        $entity->method('getPublic');
        $this->_contentQueryController = new ContentQueryController(get_class($entity));
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
        MockTest::inject($this->_contentQueryController, 'contentQuery', $em);
        $this->_contentQueryController->status('public');
        MockTest::callMockMethod($this->_contentQueryController, 'statusHandler');
    }

    public function testSelectEditPostsByStatusHandler()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('createQueryBuilder');
        $em->shouldReceive('andwhere')->once();
        MockTest::inject($this->_contentQueryController, 'contentQuery', $em);
        $this->_contentQueryController->status('edit');
        MockTest::callMockMethod($this->_contentQueryController, 'statusHandler');
    }

    public function testSelectAllPostsByStatusHandler()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('createQueryBuilder');
        $em->shouldReceive('andwhere')->never();
        MockTest::inject($this->_contentQueryController, 'contentQuery', $em);
        $this->_contentQueryController->status('all');
        MockTest::callMockMethod($this->_contentQueryController, 'statusHandler');
    }

    public function testAliasNotEmptyAndResultIsNotForced()
    {
        $method = MockTest::callMockMethod($this->_contentQueryController, 'isAliasEmptyOrIsResultForced');
        $this->assertFalse($method);
    }

    public function testAliasNotEmptyAndResultIsForced()
    {
        $this->_contentQueryController->force();
        $method = MockTest::callMockMethod($this->_contentQueryController, 'isAliasEmptyOrIsResultForced');
        $this->assertTrue($method);
    }

    public function testSetNoLimit()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('setMaxResults')->never();
        MockTest::inject($this->_contentQueryController, 'contentQuery', $em);
        MockTest::callMockMethod($this->_contentQueryController, 'setLimit');
    }

    public function testSetLimit()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('setMaxResults')->once();
        MockTest::inject($this->_contentQueryController, 'contentQuery', $em);
        $anyLimit = 1;
        $this->_contentQueryController->limit($anyLimit);
        MockTest::callMockMethod($this->_contentQueryController, 'setLimit');
    }
}
