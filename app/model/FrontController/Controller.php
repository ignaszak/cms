<?php
declare(strict_types=1);

namespace FrontController;

use Ignaszak\Registry\RegistryFactory;

/**
 *
 * @author Tomasz Ignaszak
 *
 * @property-read \Ignaszak\Registry\Registry $registry
 * @property-read \App\Resource\Http $http
 * @property-read \View\View $view
 * @property-read \DataBase\Query\Query $query
 */
abstract class Controller
{

    /**
     *
     * @var mixed[]
     */
    private static $instances = [];

    /**
     *
     * @var string
     */
    private $viewHelperName;

    abstract public function run();

    /**
     *
     * @return Controller
     */
    public static function instance(): Controller
    {
        $registry = RegistryFactory::start();
        self::$instances = [
            'registry' => $registry,
            'http' => $registry->get('http'),
            'view' => $registry->get('view'),
            'query' => $registry->register('DataBase\Query\Query')
        ];
        return new static();
    }

    /**
     *
     * @param string $property
     * @return mixed
     */
    public function __get(string $property)
    {
        return self::$instances[$property] ?? null;
    }

    /**
     * Init after Controller::run()
     */
    public function runModules()
    {
        $this->loadViewHelperSetter();
    }

    /**
     *
     * @param string $name
     */
    public function setViewHelperName(string $name)
    {
        $this->viewHelperName = $name;
    }

    /**
     *
     * @param string $name
     * @param string[] $tokens
     * @return string
     */
    public function url(string $name, array $tokens): string
    {
        return self::$instances['registry']->get('url')->url($name, $tokens);
    }

    /**
     *
     * @return boolean
     */
    private function loadViewHelperSetter(): bool
    {
        if (method_exists($this, 'setViewHelper')) {
            $instance = $this->setViewHelper();
            $class = get_class($instance);
            self::$instances['registry']->set($class, $instance);
            self::$instances['registry']->get('viewHelper')->add([$class]);
            return true;
        }
        return false;
    }
}
