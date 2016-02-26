<?php
namespace Breadcrumbs;

use Ignaszak\Registry\RegistryFactory;
use Content\Query\Content as Query;

abstract class IBreadcrumbs
{

    /**
     *
     * @var \Conf\Conf
     */
    protected $_conf;

    /**
     *
     * @var Query
     */
    protected $_query;

    /**
     *
     * @param Query $_query
     * @param array $_categoryArray
     */
    public function __construct()
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->_query = new Query();
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
            $this->addBreadcrumb('Home', '')
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
        $array->link = $this->_conf->getBaseUrl() . $link;
        $array->active = '';
        return $array;
    }
}
