<?php
namespace Test\Model\DataBase\Controller\Validator;

use Test\Mock\MockTest;
use Test\Mock\MockEntityController;
use DataBase\Controller\Validator\UniqueValidator;

class UniqueValidatorTest extends \PHPUnit_Framework_TestCase
{

    private $_uniqueValidator;

    public function setUp()
    {
        $anyEntity = \Mockery::mock('alias:Entity\AnyEntity');
        MockEntityController::mock('entityKey', $anyEntity);
        $controller = $this->getMockBuilder('\DataBase\Controller\Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $controller->method('entity')->willReturn($anyEntity);
        $this->_uniqueValidator = new UniqueValidator($controller);
    }

    public function testSetQuery()
    {
        MockTest::callMockMethod($this->_uniqueValidator, 'setQuery');
        $_query = \PHPUnit_Framework_Assert::readAttribute(
            $this->_uniqueValidator,
            '_query'
        );
        $this->assertInstanceOf('DataBase\Query\Query', $_query);
    }

    public function testSetEntityKeyByEntityName()
    {
        MockTest::callMockMethod($this->_uniqueValidator, 'setEntityKey');
        $this->assertEquals(
            'entityKey',
            \PHPUnit_Framework_Assert::readAttribute(
                $this->_uniqueValidator,
                'entityKey'
            )
        );
    }

    public function testDataNotExistsInDatabase()
    {
        MockTest::inject(
            $this->_uniqueValidator,
            '_query',
            $this->mockQuery([])
        );
        $result = MockTest::callMockMethod(
            $this->_uniqueValidator,
            'dataNotExistInDatabase',
            ['column', 'value', []]
        );
        $this->assertTrue($result);
    }

    public function testDataExistsInDatabase()
    {
        MockTest::inject(
            $this->_uniqueValidator,
            '_query',
            $this->mockQuery(['value'])
        );
        $result = MockTest::callMockMethod(
            $this->_uniqueValidator,
            'dataNotExistInDatabase',
            ['column', 'value', []]
        );
        $this->assertFalse($result);
    }

    public function testDataExistsInDatabaseWithException()
    {
        $stub = $this->mockQuery(['value']);
        $stub->shouldReceive('query')->once();
        MockTest::inject($this->_uniqueValidator, '_query', $stub);
        $result = MockTest::callMockMethod(
            $this->_uniqueValidator,
            'dataNotExistInDatabase',
            ['column', 'value', ['exception']]
        );
        $this->assertFalse($result);
    }

    private function mockQuery(array $return)
    {
        $stub = \Mockery::mock('Query');
        $stub->shouldReceive([
            'setQuery' => $stub,
            'findBy' => $stub,
            'force' => $stub,
            'paginate' => $stub,
            'getQuery' => $return,
            'getStaticQuery' => $return
        ]);
        return $stub;
    }
}
