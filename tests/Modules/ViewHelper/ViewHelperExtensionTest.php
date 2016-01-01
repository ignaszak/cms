<?php

namespace Test\Modules\ViewHelper;

use Test\Mock\MockTest;
use ViewHelper\ViewHelperExtension;
use Test\Init\InitViewHelper;

class ViewHelperExtensionTest extends \PHPUnit_Framework_TestCase
{

    private $_viewHelperExtension;

    public function setUp()
    {
        $this->_viewHelperExtension = new ViewHelperExtension;
    }

    public function tearDown()
    {
        InitViewHelper::clearExtensions();
    }

    public function testGetExtensionInstanceFromMethodName()
    {
        $name = 'getSiteTitle';
        $getExtensionInstanceFromMethodName = MockTest::callMockMethod($this->_viewHelperExtension, 'getExtensionInstanceFromMethodName', array($name));
        $this->assertInstanceOf('ViewHelper\Extension\\System', $getExtensionInstanceFromMethodName);
    }

    public function testAddExtensionClass()
    {
        ViewHelperExtension::addExtensionClass(array(
            'ViewHelper\\Extension\\User',
            'Form\\Form'
        ));
        ViewHelperExtension::addExtensionClass('Content\\Query\\Content');
        $extensionClassNameArray = \PHPUnit_Framework_Assert::readAttribute($this->_viewHelperExtension, 'extensionClassNameArray');
        $this->assertEquals(array(
            'ViewHelper\\Extension\\User',
            'Form\\Form',
            'Content\\Query\\Content'
        ), $extensionClassNameArray);
    }

    public function testReturnExtensionClassNameFromMethodName()
    {
        $name = 'getSiteTitle';
        $returnExtensionClassNameFromMethodName = MockTest::callMockMethod($this->_viewHelperExtension, 'returnExtensionClassNameFromMethodName', array($name));
        $this->assertEquals('ViewHelper\Extension\\System', $returnExtensionClassNameFromMethodName);
    }

    public function testGetClassNameWithoutNamespace()
    {
        $name = 'Test\Modules\ViewHelper';
        $getClassNameWithoutNamespace = MockTest::callMockMethod($this->_viewHelperExtension, 'getClassNameWithoutNamespace', array($name));
        $this->assertEquals('ViewHelper', $getClassNameWithoutNamespace);
    }

}
