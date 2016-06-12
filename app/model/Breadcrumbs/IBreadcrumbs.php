<?php
namespace Breadcrumbs;

use Ignaszak\Registry\RegistryFactory;

abstract class IBreadcrumbs
{

    /**
     *
     * @var \Conf\Conf
     */
    protected $conf = null;

    /**
     *
     * @var \DataBase\Query\Query
     */
    protected $query = null;

    /**
     *
     * @var \App\Resource\Http
     */
    protected $http = null;

    /**
     *
     * @var \Ignaszak\Registry\RegistryFactory
     */
    protected $registry = null;

    public function __construct()
    {
        $this->registry = RegistryFactory::start();
        $this->conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->query = $this->registry->register('DataBase\Query\Query');
        $this->http = $this->registry->get('http');
    }

    /**
     * @return array
     */
    abstract public function createBreadcrumbs(): array;

    /**
     * @return array
     */
    protected function getHome(): array
    {
        return [
            $this->addBreadcrumb(
                'Home',
                $this->registry->get('url')->url('default')
            )
        ];
    }

    /**
     *
     * @param string $title
     * @param string $link
     * @return \stdClass
     */
    protected function addBreadcrumb(string $title, string $link): \stdClass
    {
        $array = new \stdClass();
        $array->title = $title;
        $array->link = $link;
        $array->active = '';
        return $array;
    }
}
