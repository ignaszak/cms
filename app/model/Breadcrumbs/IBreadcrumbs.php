<?php
namespace Breadcrumbs;

use Ignaszak\Registry\RegistryFactory;

abstract class IBreadcrumbs
{

    /**
     *
     * @var \Conf\Conf
     */
    protected $_conf;

    /**
     *
     * @var \DataBase\Query\Query
     */
    protected $_query;

    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->_query = RegistryFactory::start()
            ->register('DataBase\Query\Query');
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
            $this->addBreadcrumb('Home', $this->_conf->getBaseUrl())
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
