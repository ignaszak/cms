<?php

namespace Test\Modules\Content\Query;

use Content\Query\ContentQueryController;
use Test\Init\InitDoctrine;
use Test\Init\InitConf;
use Test\Init\InitRouter;
use Test\Mock\MockTest;

class ContentQueryControllerTest extends \PHPUnit_Framework_TestCase
{

    private $_contentQueryController;

    public function setUp()
    {
        InitRouter::start('route');
        InitRouter::add('admin', '{alias:route}');
        InitRouter::run();
        InitConf::run();
        InitDoctrine::queryBuilderResult(array(null)); // Symulate no result
        $entity = $this->getMockBuilder('Entity\Posts')->getMock();
        $entity->method('getPublic');
        $this->_contentQueryController = new ContentQueryController(get_class($entity));
    }

    public function tearDown()
    {
        InitDoctrine::clear();
    }

    public function testSelectOnlyPublicPostsByStatusHandler()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('createQueryBuilder');
        $em->shouldReceive('andwhere')->once();
        $this->_contentQueryController->contentQuery = $em;
        $this->_contentQueryController->status('public');
        MockTest::callMockMethod($this->_contentQueryController, 'statusHandler');
    }

    public function testSelectEditPostsByStatusHandler()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('createQueryBuilder');
        $em->shouldReceive('andwhere')->once();
        $this->_contentQueryController->contentQuery = $em;
        $this->_contentQueryController->status('edit');
        MockTest::callMockMethod($this->_contentQueryController, 'statusHandler');
    }

    public function testSelectAllPostsByStatusHandler()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('createQueryBuilder');
        $em->shouldReceive('andwhere')->never();
        $this->_contentQueryController->contentQuery = $em;
        $this->_contentQueryController->status('all');
        MockTest::callMockMethod($this->_contentQueryController, 'statusHandler');
    }

    public function testAliasNotEmptyAndResultIsNotForced()
    {
        $method = MockTest::callMockMethod($this->_contentQueryController,
            'isAliasEmptyOrIsResultForced');
        $this->assertFalse($method);
    }

    public function testAliasNotEmptyAndResultIsForced()
    {
        $this->_contentQueryController->force();
        $method = MockTest::callMockMethod($this->_contentQueryController,
            'isAliasEmptyOrIsResultForced');
        $this->assertTrue($method);
    }

    public function testSetNoLimit()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('setMaxResults')->never();
        $this->_contentQueryController->contentQuery = $em;
        MockTest::callMockMethod($this->_contentQueryController, 'setLimit');
    }

    public function testSetLimit()
    {
        $em = \Mockery::mock('EntityManager');
        $em->shouldReceive('setMaxResults')->once();
        $this->_contentQueryController->contentQuery = $em;
        $anyLimit = 1;
        $this->_contentQueryController->limit($anyLimit);
        MockTest::callMockMethod($this->_contentQueryController, 'setLimit');
    }

}
