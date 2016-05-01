<?php
namespace Test\Model\View;

use View\ViewHelper;

class ViewHelperTest extends \PHPUnit_Framework_TestCase
{

    private $viewHelper = null;

    public function setUp()
    {
        $this->viewHelper = new ViewHelper();
    }

    public function testAdd()
    {
        $this->viewHelper->add(['View\View']);
        $this->assertEquals(
            $this->viewHelper->getMethods(),
            [
                'addView' => 'View\View',
                'loadView' => 'View\View',
                'loadFile' => 'View\View',
                'getThemeFolder' => 'View\View'
            ]
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testAddDuplicate()
    {
        $this->viewHelper->add(['View\View', 'View\View']);
    }
}
