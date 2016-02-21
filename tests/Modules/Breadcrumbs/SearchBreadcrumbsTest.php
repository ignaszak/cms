<?php
namespace Test\Modules\Breadcrumbs;

use Breadcrumbs\SearchBreadcrumbs;

class SearchBreadcrumbsTest extends \PHPUnit_Framework_TestCase
{

    private $_searchBc;

    public function setUp()
    {
        $this->_searchBc = new SearchBreadcrumbs();
    }

    public function testCreateBreadcrumbs()
    {
        $array = $this->_searchBc->createBreadcrumbs();
        $this->assertEquals('Home', $array[0]->title);
        $this->assertEquals('Search', $array[1]->title);
    }
}
