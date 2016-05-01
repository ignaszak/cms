<?php
namespace Test\Model\App\Admin;

use Test\Mock\MockTest;
use Test\Mock\MockConf;
use App\Admin\AdminExtension;

class AdminExtensionTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var AdminExtension
     */
    private $_adminExtension = null;

    public function setUp()
    {
        MockConf::setConstants();
        $this->_adminExtension = new AdminExtension('');
    }

    public function testLoadExtensionConfFileArray()
    {
        $structure = [
            'Menu' => [
                'router.yml' => '',
                'conf.yml' => ''
            ],
            'Post' => [
                'router.yml' => '',
                'conf.yml' => ''
            ],
            'Page' => [
                'router.yml' => '',
                'conf.yml' => ''
            ]
        ];
        MockTest::callMockMethod(
            $this->_adminExtension,
            'loadExtensionArray',
            [MockTest::mockFileSystem($structure)]
        );
        $this->assertEquals(
            [
                2 => 'Menu',
                3 => 'Page',
                4 => 'Post'
            ],
            \PHPUnit_Framework_Assert::readAttribute(
                $this->_adminExtension,
                'extensionsArray'
            )
        );
    }

    public function testGetAdminExtensionsRouteYaml()
    {
        $structure = [
            'Menu' => [
                'router.yml' => '',
                'conf.yml' => ''
            ],
            'Post' => [
                'router.yml' => '',
                'conf.yml' => ''
            ],
            'Page' => [
                'conf.yml' => ''
            ]
        ];
        $this->_adminExtension = new AdminExtension(
            MockTest::mockFileSystem($structure)
        );
        MockTest::inject(
            $this->_adminExtension,
            'extensionsArray',
            ['Menu', 'Page', 'Post']
        );
        $this->assertEquals(
            [
                'vfs://mock/Menu/router.yml',
                'vfs://mock/Post/router.yml',
            ],
            $this->_adminExtension->getAdminExtensionsRouteYaml()
        );
    }
}
