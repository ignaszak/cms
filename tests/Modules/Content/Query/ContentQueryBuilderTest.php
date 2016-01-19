<?php

namespace Test\Modules\Content\Query;

use Content\Query\ContentQueryBuilder;
use Content\Query\IContentQueryController;
use Test\Init\InitDoctrine;
use Test\Mock\MockTest;

class ContentQueryBuilderTest extends \PHPUnit_Framework_TestCase
{

    private $_contentQueryBuilder;

    public function tearDown()
    {
        InitDoctrine::clear();
    }

    public function testSet()
    {
        $stub = \Mockery::mock('QuerBuilder');
        $stub->shouldReceive('andwhere')->andReturnSelf()->once();
        $stub->shouldReceive('setParameter')->andReturnSelf()->once();
        $this->_contentQueryBuilder = new ContentQueryBuilder(
            $this->getMockIContentQueryController($stub)
        );
        MockTest::callMockMethod($this->_contentQueryBuilder, 'set', array('column', 'value'));
    }

    private function getMockIContentQueryController($contentQuery = null): IContentQueryController
    {
        $stub = \Mockery::mock('alias:\Content\Query\IContentQueryController');
        $stub->contentQuery = $contentQuery;
        $stub->shouldReceive('setContentQuery');

        return $stub;
    }

}
