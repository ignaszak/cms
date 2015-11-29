<?php

namespace Test\Modules\Display;

use Test\Mock\MockTest;
use Display\DisplayExtension;

class DisplayExtensionTest extends \PHPUnit_Framework_TestCase
{

    private $_displayExtension;

    public function setUp()
    {
        $this->_displayExtension = new DisplayExtension;
    }

    public function testGetExtensionInstanceFromMethodName()
    {
        $name = 'getSiteTitle';
        $getExtensionInstanceFromMethodName = MockTest::callMockMethod($this->_displayExtension, 'getExtensionInstanceFromMethodName', array($name));
        $this->assertInstanceOf('Display\Extension\\System', $getExtensionInstanceFromMethodName);
    }

    public function testAddExtensionClass()
    {
        DisplayExtension::addExtensionClass(array(
            'Display\\Extension\\User',
            'Form\\Form'
        ));
        DisplayExtension::addExtensionClass('Content\\Query\\Content');
        $extensionClassNameArray = \PHPUnit_Framework_Assert::readAttribute($this->_displayExtension, 'extensionClassNameArray');
        $this->assertEquals(array(
            'Display\\Extension\\User',
            'Form\\Form',
            'Content\\Query\\Content'
        ), $extensionClassNameArray);
    }

    public function testReturnExtensionClassNameFromMethodName()
    {
        $name = 'getSiteTitle';
        $returnExtensionClassNameFromMethodName = MockTest::callMockMethod($this->_displayExtension, 'returnExtensionClassNameFromMethodName', array($name));
        $this->assertEquals('Display\Extension\\System', $returnExtensionClassNameFromMethodName);
    }

    public function testGetClassNameWithoutNamespace()
    {
        $name = 'Test\Modules\Display';
        $getClassNameWithoutNamespace = MockTest::callMockMethod($this->_displayExtension, 'getClassNameWithoutNamespace', array($name));
        $this->assertEquals('Display', $getClassNameWithoutNamespace);
    }

}
