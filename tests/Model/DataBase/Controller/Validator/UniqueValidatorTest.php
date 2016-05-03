<?php
namespace Test\Model\DataBase\Controller\Validator;

use Test\Mock\MockTest;
use Test\Mock\MockEntityController;
use DataBase\Controller\Validator\UniqueValidator;

class UniqueValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \DataBase\Controller\Validator\UniqueValidator
     */
    private $uniqueValidator;

    public function setUp()
    {
        $anyEntity = \Mockery::mock('alias:Entity\AnyEntity');
        MockEntityController::mock('entityKey', $anyEntity);
        $controller = $this->getMockBuilder('\DataBase\Controller\Controller')
            ->disableOriginalConstructor()
            ->getMock();
        $controller->method('entity')->willReturn($anyEntity);
        $this->uniqueValidator = new UniqueValidator($controller);
    }

    public function testSetQuery()
    {
        MockTest::callMockMethod($this->uniqueValidator, 'setQuery');
        $_query = \PHPUnit_Framework_Assert::readAttribute(
            $this->uniqueValidator,
            'query'
        );
        $this->assertInstanceOf('DataBase\Query\Query', $_query);
    }

    public function testSetEntityKeyByEntityName()
    {
        MockTest::callMockMethod($this->uniqueValidator, 'setEntityKey');
        $this->assertEquals(
            'entityKey',
            \PHPUnit_Framework_Assert::readAttribute(
                $this->uniqueValidator,
                'entityKey'
            )
        );
    }

    public function testDataNotExistsInDatabase()
    {
        MockTest::inject(
            $this->uniqueValidator,
            'query',
            $this->mockQuery([])
        );
        $result = MockTest::callMockMethod(
            $this->uniqueValidator,
            'dataNotExistInDatabase',
            ['column', 'value', []]
        );
        $this->assertTrue($result);
    }

    public function testDataExistsInDatabase()
    {
        MockTest::inject(
            $this->uniqueValidator,
            'query',
            $this->mockQuery(['value'])
        );
        $result = MockTest::callMockMethod(
            $this->uniqueValidator,
            'dataNotExistInDatabase',
            ['column', 'value', []]
        );
        $this->assertFalse($result);
    }

    public function testDataExistsInDatabaseWithException()
    {
        $stub = $this->mockQuery(['value']);
        $stub->shouldReceive('query')->once();
        MockTest::inject($this->uniqueValidator, 'query', $stub);
        $result = MockTest::callMockMethod(
            $this->uniqueValidator,
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
