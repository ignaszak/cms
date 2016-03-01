<?php
namespace Test\Model\ViewHelper;

use Test\Mock\MockTest;
use ViewHelper\ViewHelperExtension;
use Test\Mock\MockViewHelper;

class ViewHelperExtensionTest extends \PHPUnit_Framework_TestCase
{

    private $_viewHelperExtension;

    public function setUp()
    {
        $this->_viewHelperExtension = new ViewHelperExtension();
    }

    public function tearDown()
    {
        MockViewHelper::clearExtensions();
    }

    public function testGetExtensionInstanceFromMethodName()
    {
        $name = 'getSiteTitle';
        $getExtensionInstanceFromMethodName = MockTest::callMockMethod(
            $this->_viewHelperExtension,
            'getExtensionInstanceFromMethodName',
            [$name]
        );
        $this->assertInstanceOf(
            'ViewHelper\Extension\\System',
            $getExtensionInstanceFromMethodName
        );
    }

    public function testAddExtensionClass()
    {
        ViewHelperExtension::addExtensionClass(array(
            'ViewHelper\\Extension\\User',
            'Form\\Form'
        ));
        ViewHelperExtension::addExtensionClass('AnyExtensionClass');
        $extensionClassNameArray = \PHPUnit_Framework_Assert::readAttribute(
            $this->_viewHelperExtension,
            'extensionClassNameArray'
        );
        $this->assertEquals(
            [
                'ViewHelper\\Extension\\User',
                'Form\\Form',
                'AnyExtensionClass'
            ],
            $extensionClassNameArray
        );
    }

    public function testReturnExtensionClassNameFromMethodName()
    {
        $name = 'getSiteTitle';
        $returnExtensionClassNameFromMethodName = MockTest::callMockMethod(
            $this->_viewHelperExtension,
            'returnExtensionClassNameFromMethodName',
            [$name]
        );
        $this->assertEquals(
            'ViewHelper\Extension\\System',
            $returnExtensionClassNameFromMethodName
        );
    }

    public function testGetClassNameWithoutNamespace()
    {
        $name = 'Test\Model\ViewHelper';
        $getClassNameWithoutNamespace = MockTest::callMockMethod(
            $this->_viewHelperExtension,
            'getClassNameWithoutNamespace',
            [$name]
        );
        $this->assertEquals('ViewHelper', $getClassNameWithoutNamespace);
    }
}
