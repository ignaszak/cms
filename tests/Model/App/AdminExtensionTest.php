<?php
namespace Test\Model\App;

use org\bovigo\vfs\vfsStream;
use Test\Mock\MockTest;
use Test\Mock\MockConf;

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
        $this->_adminExtension = (new \ReflectionClass('App\AdminExtension'))
            ->newInstanceWithoutConstructor();
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
            [$this->mockExtensions($structure)]
        );
        $this->assertEquals(
            [
                2 => 'Menu',
                3 => 'Page',
                4 => 'Post'
            ],
            \PHPUnit_Framework_Assert::readAttribute(
                $this->_adminExtension, 'extensionsArray'
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
        MockTest::inject(
            $this->_adminExtension, 'extensionsArray', ['Menu', 'Page', 'Post']
        );
        MockTest::inject(
            $this->_adminExtension,
            'extensionBaseDir',
            $this->mockExtensions($structure)
        );
        $this->assertEquals(
            [
                'vfs://root/Menu/router.yml',
                'vfs://root/Post/router.yml',
            ],
            $this->_adminExtension->getAdminExtensionsRouteYaml()
        );
    }

    private function mockExtensions(array $structure): string
    {
        $vfs = vfsStream::setup('root');
        vfsStream::create($structure, $vfs);
        return vfsStream::url('root');
    }
}
