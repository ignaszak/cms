<?php
namespace ViewHelper\Extension;

use Ignaszak\Registry\RegistryFactory;
use App\Resource\RouterStatic as Router;

class Post
{

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $_query;

    /**
     *
     * @var \Entity\Posts[]
     */
    private $_post = [];

    public function __construct()
    {
        $this->_query = RegistryFactory::start()->register('DataBase\Query\Query');
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
        switch (Router::getRoute()) {

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
                    ->date(Router::getRoute('date'))
                    ->force();
                break;

            default:
                $this->_query->setQuery('post');
        }
        $this->_post = $this->_query->getQuery();
    }
}
