<?php
namespace Test\Modules\Content\Query;

use Content\Query\ContentQueryBuilder;
use Content\Query\IContentQueryController;
use Test\Init\InitDoctrine;
use Test\Mock\MockTest;

class ContentQueryBuilderTest extends \PHPUnit_Framework_TestCase
{

    private $_contentQueryBuilder;

    public function setUp()
    {
        $this->_contentQueryBuilder = new ContentQueryBuilder($this->getMockIContentQueryController(InitDoctrine::queryBuilder(array(
            null
        ))));
    }

    public function tearDown()
    {
        InitDoctrine::clear();
    }

    public function testSet()
    {
        $this->mockAndWhereAndSetParameterMethods();
        MockTest::callMockMethod($this->_contentQueryBuilder, 'set', array(
            'column',
            'value'
        ));
    }

    public function testGetReference()
    {
        $column = 'table.column';
        $reference = MockTest::callMockMethod($this->_contentQueryBuilder, 'getReference', array(
            $column
        ));
        $this->assertEquals('table', $reference);
    }

    public function testGetEmptyReference()
    {
        $column = '';
        $reference = MockTest::callMockMethod($this->_contentQueryBuilder, 'getReference', array(
            $column
        ));
        $this->assertEmpty($reference);
    }

    public function testLike()
    {
        $this->mockAndWhereAndSetParameterMethods();
        MockTest::callMockMethod($this->_contentQueryBuilder, 'like', array(
            'column',
            'value'
        ));
    }

    public function testJoin()
    {
        $stub = \Mockery::mock('QuerBuilder');
        $stub->shouldReceive('join')
            ->andReturnSelf()
            ->once();
        $this->_contentQueryBuilder = new ContentQueryBuilder($this->getMockIContentQueryController($stub));
        MockTest::callMockMethod($this->_contentQueryBuilder, 'join', array(
            'column'
        ));
    }

    public function testAddMysqlDateFormatExtension()
    {
        $stub = \Mockery::mock('EntityManager');
        $stub->shouldReceive('getConfiguration')
            ->andReturnSelf()
            ->once();
        $stub->shouldReceive('addCustomDatetimeFunction')
            ->andReturnSelf()
            ->once();
        InitDoctrine::mock($stub);
        $this->_contentQueryBuilder->date('2016-01-19');
    }

    private function mockAndWhereAndSetParameterMethods()
    {
        $stub = \Mockery::mock('QuerBuilder');
        $stub->shouldReceive('andwhere')
            ->andReturnSelf()
            ->once();
        $stub->shouldReceive('setParameter')
            ->andReturnSelf()
            ->once();
        $this->_contentQueryBuilder = new ContentQueryBuilder($this->getMockIContentQueryController($stub));
    }

    private function getMockIContentQueryController($contentQuery = null): IContentQueryController
    {
        $stub = \Mockery::mock('alias:\Content\Query\IContentQueryController');
        $stub->contentQuery = $contentQuery;
        $stub->shouldReceive('setContentQuery');
        
        return $stub;
    }
}
