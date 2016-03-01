<?php
namespace Test\Model\DataBase\Query;

use Test\Mock\MockDoctrine;
use Test\Mock\MockTest;
use DataBase\Query\QueryBuilder;
use DataBase\Query\IQueryController;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{

    private $_queryBuilder;

    public function setUp()
    {
        $this->_queryBuilder = new QueryBuilder(
            $this->getMockIQueryController(
                MockDoctrine::queryBuilder([null])
            )
        );
    }

    public function tearDown()
    {
        MockDoctrine::clear();
    }

    public function testSet()
    {
        $this->mockAndWhereAndSetParameterMethods();
        MockTest::callMockMethod($this->_queryBuilder, 'set', [
            'column',
            'value'
        ]);
    }

    public function testGetReference()
    {
        $column = 'table.column';
        $reference = MockTest::callMockMethod(
            $this->_queryBuilder,
            'getReference',
            [$column]
        );
        $this->assertEquals('table', $reference);
    }

    public function testGetEmptyReference()
    {
        $column = '';
        $reference = MockTest::callMockMethod(
            $this->_queryBuilder,
            'getReference',
            [$column]
        );
        $this->assertEmpty($reference);
    }

    public function testLike()
    {
        $this->mockAndWhereAndSetParameterMethods();
        MockTest::callMockMethod($this->_queryBuilder, 'like', [
            'column',
            'value'
        ]);
    }

    public function testJoin()
    {
        $stub = \Mockery::mock('alias:\Doctrine\ORM\QueryBuilder');
        $stub->shouldReceive('join')
            ->andReturnSelf()
            ->once();
        $this->_queryBuilder = new QueryBuilder(
            $this->getMockIQueryController($stub)
        );
        MockTest::callMockMethod($this->_queryBuilder, 'join', [
            'column'
        ]);
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
        MockDoctrine::mock($stub);
        $this->_queryBuilder->date('2016-01-19');
    }

    private function mockAndWhereAndSetParameterMethods()
    {
        $stub = \Mockery::mock('alias:\Doctrine\ORM\QueryBuilder');
        $stub->shouldReceive('andwhere')
            ->andReturnSelf()
            ->once();
        $stub->shouldReceive('setParameter')
            ->andReturnSelf()
            ->once();
        $this->_queryBuilder = new QueryBuilder(
            $this->getMockIQueryController($stub)
        );
    }

    private function getMockIQueryController($query = null): IQueryController
    {
        $stub = $this->getMockBuilder('DataBAse\Query\IQueryController')
            ->getMock();
        $stub->method('updateQuery');
        $stub->method('__get')->willReturn($query);
        return $stub;
    }
}
