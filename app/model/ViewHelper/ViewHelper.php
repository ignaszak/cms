<?php
namespace ViewHelper;

use Conf\Conf;
use App\Resource\RouterStatic as Router;
use Ignaszak\Registry\RegistryFactory;

class ViewHelper
{

    /**
     *
     * @var ViewHelperExtension
     */
    private $_viewHelperExtension;

    /**
     *
     * @var Conf
     */
    private $_conf;

    public function __construct()
    {
        $this->_viewHelperExtension = new ViewHelperExtension();
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
    }

    /**
     * Searches for correspond class based on method name.
     * If is found creates an object and call a method.
     *
     * @param string $name
     * @param array $arguments
     * @throws \RuntimeException
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        $extensionInstance = $this->_viewHelperExtension
            ->getExtensionInstanceFromMethodName($name);

        if (method_exists($extensionInstance, $name)) {
            return call_user_func_array([$extensionInstance, $name], $arguments);
        } else {
            throw new \RuntimeException(
                "No class correspond to <b>$name</b> method"
            );
        }
    }

    /**
     * Returns current entity based on client request
     *
     * @return array
     */
    public function display(): array
    {
        $_query = $this->_viewHelperExtension
            ->getExtensionInstanceFromMethodName('Query');

        switch (Router::getRoute()) {

            case 'post':
                $_query->setQuery('post');
                break;

            case 'category':
                $_query->setQuery('post')
                    ->categoryId(RegistryFactory::start()
                        ->register('App\Resource\CategoryList')->child())
                    ->force();
                break;

            case 'date':
                $_query->setQuery('post')
                    ->date(Router::getRoute('date'))
                    ->force();
                break;

            default:
                $_query->setQuery('post');
        }

        return $_query->getQuery();
    }
}
