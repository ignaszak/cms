<?php
namespace View\Extension;

use Ignaszak\Registry\RegistryFactory;

class Post
{

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $_query = null;

    /**
     *
     * @var \App\Resource\Http
     */
    private $http = null;

    /**
     *
     * @var \DataBase\Query\Entity[]
     */
    private $_post = [];

    public function __construct()
    {
        $registry = RegistryFactory::start();
        $this->_query = $registry->register('DataBase\Query\Query');
        $this->http = $registry->get('http');
    }

    /**
     *
     * @return boolean
     */
    public function havePost(): bool
    {
        if (empty($this->_post)) {
            $this->selectPosts();
        }
        return count($this->_post);
    }

    /**
     *
     * @return \Entity\Posts[]
     */
    public function getPosts(): array
    {
        if (empty($this->_post)) {
            $this->selectPosts();
        }
        return $this->_post;
    }

    private function selectPosts()
    {
        switch ($this->http->router->group()) {
            case 'post':
                $this->_query->setQuery('post');
                break;
            case 'category':
                $catIdArray = RegistryFactory::start()
                    ->register('App\Resource\CategoryList')->child();
                $this->_query->setQuery('post')
                    ->categoryId($catIdArray)
                    ->force();
                break;
            case 'date':
                $this->_query->setQuery('post')
                    ->date($this->getDate())
                    ->force();
                break;
            default:
                $this->_query->setQuery('post');
        }
        $this->_post = $this->_query->getQuery();
    }

    /**
     *
     * @return string
     */
    private function getDate(): string
    {
        $date = $this->http->router->all();
        return implode('-', array_filter($date, function ($var) {
            return !in_array($var, ['', '-']);
        }));
    }
}
