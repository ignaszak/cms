<?php
namespace Test\Mock;

use Ignaszak\Registry\RegistryFactory;

class MockHttp
{

    /**
     *
     * @var array
     */
    private static $routerResponse = [];

    /**
     *
     * @param string $name
     */
    public static function routeName(string $name)
    {
        self::$routerResponse['name'] = $name;
    }

    /**
     *
     * @param string $controller
     */
    public static function routeController(string $controller)
    {
        self::$routerResponse['controller'] = $controller;
    }

    /**
     *
     * @param \Closure $attachment
     */
    public static function routeAttach(\Closure $attachment, bool $throwable = true)
    {
        self::$routerResponse['attachment'] = $attachment;
        self::$routerResponse['callAttachment'] = $throwable;
    }

    /**
     *
     * @param array $params
     */
    public static function routeSet(array $params)
    {
        self::$routerResponse['params'] = $params;
    }

    /**
     *
     * @param string $group
     */
    public static function routeGroup(string $group)
    {
        self::$routerResponse['group'] = $group;
    }

    public static function run()
    {
        $stub = \Mockery::mock('Http');
        $stub->router = self::mockRouter();
        RegistryFactory::start()->set('http', $stub);
    }

    private static function mockRouter()
    {
        $router = \Mockery::mock('Router');
        $router->shouldReceive('get')->andReturnUsing(
            function (string $token, $default = null) {
                return self::$routerResponse['params'][$token] ?? $default;
            }
        );
        $router->shouldReceive('has')->andReturnUsing(
            function (string $token) {
                return array_key_exists(
                    $token,
                    self::$routerResponse['params']
                );
            }
        );
        $router->shouldReceive([
            'name' => self::$routerResponse['name'] ?? '',
            'controller' => self::$routerResponse['controller'] ?? '',
            'attachment' => self::$routerResponse['attachment'] ?? function () {
            },
            'all' => self::$routerResponse['params'] ?? [],
            'group' => self::$routerResponse['group'] ?? '',
            'tokens' => array_keys(self::$routerResponse['params'] ?? [])
        ]);
        return $router;
    }
}
