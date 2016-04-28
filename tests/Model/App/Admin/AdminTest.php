<?php
namespace Test\Model\App\Admin;

use App\Admin\Admin;
use Test\Mock\MockTest;
use App\Yaml;
use Ignaszak\Registry\RegistryFactory;

class AdminTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var AdminMenu
     */
    private $_adminMenu = null;

    public function setUp()
    {
        RegistryFactory::start()->set('http', $this->mockHttp());
        $this->_adminMenu = new Admin(
            $this->mockAdminExtension(),
            $this->mockYaml()
        );

    }

    public function testConstructor()
    {
        $this->assertInstanceOf(
            'App\Admin\AdminExtension',
            \PHPUnit_Framework_Assert::readAttribute(
                $this->_adminMenu, '_adminExtension'
            )
        );
        $this->assertInstanceOf(
            'App\Yaml',
            \PHPUnit_Framework_Assert::readAttribute(
                $this->_adminMenu, '_yaml'
            )
        );
        $this->assertInstanceOf(
            'Ignaszak\Registry\Registry',
            \PHPUnit_Framework_Assert::readAttribute(
                $this->_adminMenu, '_registry'
            )
        );
    }

    public function testGetAdminMenu()
    {
        $stub = \Mockery::mock('UrlGenerator');
        $stub->shouldReceive('url')->andReturn('generatedUrl');
        RegistryFactory::start()->set('url', $stub);
        $structure = [
            'Post' => [
                'conf.yml' => <<<EOT
title: Post
icon: fa fa-thumb-tack
menu:
    - {title: Add new post, url: admin-post-add, tokens: {action: add}}
    - {title: Add new post 2, url: admin-post-add-2, tokens: {action: add-2}}
EOT
            ]
        ];
        $this->_adminMenu = new Admin(
            $this->mockAdminExtension(
                MockTest::mockFileSystem($structure),
                ['Post']
            ),
            new Yaml()
        );

        $this->assertEquals(
            [
                0 => [
                    'active' => false,
                    'title' => 'Post',
                    'icon' => 'fa fa-thumb-tack',
                    'menu' => [
                        0 => [
                            'active' => false,
                            'title' => 'Add new post',
                            'url' => 'generatedUrl'
                        ],
                        1 => [
                            'active' => false,
                            'title' => 'Add new post 2',
                            'url' => 'generatedUrl'
                        ]
                    ]
                ]
            ],
            $this->_adminMenu->getAdminMenu()
        );
    }

    public function testActive()
    {
        RegistryFactory::start()->set(
            'http',
            $this->mockHttp('Page', 'admin-post-add')
        );
        $structure = [
            'Post' => [
                'conf.yml' => ''
            ],
            'Page' => [
                'conf.yml' => <<<EOT
menu:
    - {title: Add new post, url: admin-post-add, tokens: {action: add}}
    - {title: Add new post 2, url: admin-post-add-2, tokens: {action: add-2}}
EOT
            ]
        ];
        $this->_adminMenu = new Admin(
            $this->mockAdminExtension(
                MockTest::mockFileSystem($structure),
                ['Post', 'Page']
            ),
            new Yaml()
        );print_r($this->_adminMenu->getAdminMenu());
        $this->assertEquals(
            [
                0 => [
                    'active' => false
                ],
                1 => [
                    'active' => true,
                    'menu' => [
                        0 => [
                            'active' => true,
                            'title' => 'Add new post',
                            'url' => 'generatedUrl'
                        ],
                        1 => [
                            'active' => false,
                            'title' => 'Add new post 2',
                            'url' => 'generatedUrl'
                        ]
                    ]
                ]
            ],
            $this->_adminMenu->getAdminMenu()
        );
    }

    private function mockAdminExtension(
        string $extensionDir = '',
        array $extensionsArray = []
    ) {
        $stub = $this->getMockBuilder('App\Admin\AdminExtension')
            ->disableOriginalConstructor()->getMock();
        $stub->extensionDir = $extensionDir;
        $stub->extensionsArray = $extensionsArray;
        return $stub;
    }

    private function mockYaml(array $result = [])
    {
        $stub = $this->getMockBuilder('App\Yaml')
            ->disableOriginalConstructor()->getMock();
        $stub->method('parse')->willReturn($result);
        return $stub;
    }

    private function mockHttp(string $group = '', string $name = '')
    {
        $stub = $this->getMockBuilder('App\Resource\Http')
            ->disableOriginalConstructor()->getMock();
        $router = \Mockery::mock('Router');
        $router->shouldReceive('group')->andReturn($group);
        $router->shouldReceive('name')->andReturn($name);
        $stub->router = $router;
        return $stub;
    }
}
