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
        $this->_contentQueryBuilder = new ContentQueryBuilder(
            $this->getMockIContentQueryController()
        );
    }

    public function tearDown()
    {
        InitDoctrine::clear();
    }

    public function testSet()
    {
        $this->_contentQueryBuilder
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
