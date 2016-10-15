<?php
namespace Test\Model\DataBase\Query;

use Test\Mock\MockDoctrine;
use Test\Mock\MockEntityController;
use Test\Mock\MockConf;
use DataBase\Query\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $query;

    /**
     *
     * @var string
     */
    private $result;

    public function setUp()
    {
        MockConf::run();
        $this->result = 'anyResult';
        MockDoctrine::queryBuilderResult([$this->result]);
        $this->query = new Query();
    }

    public function tearDown()
    {
        MockDoctrine::clear();
    }

    public function testReturnResultFromQueryBuilder()
    {
        $stub = \Mockery::mock('Entity\Posts');
        MockEntityController::mock('post', $stub);
        $entityName = \PHPUnit_Framework_Assert::readAttribute(
            $this->query->setQuery('post'),
            'entityName'
        );
        $this->assertEquals('Entity\Posts', $entityName);
    }
}
