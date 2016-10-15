<?php
namespace View\Extension;

use Ignaszak\Registry\RegistryFactory;

class Post
{

    /**
     *
     * @var \DataBase\Query\Query
     */
    private $query = null;

    /**
     *
     * @var \App\Resource\Http
     */
    private $http = null;

    /**
     *
     * @var \DataBase\Query\Entity[]
     */
    private $post = [];

    public function __construct()
    {
        $registry = RegistryFactory::start();
        $this->query = $registry->register('DataBase\Query\Query');
        $this->http = $registry->get('http');
    }

    /**
     *
     * @return boolean
     */
    public function havePost(): bool
    {
        if (empty($this->post)) {
            $this->selectPosts();
        }
        return count($this->post);
    }

    /**
     *
     * @return \Entity\Posts[]
     */
    public function getPosts(): array
    {
        if (empty($this->post)) {
            $this->selectPosts();
        }
        return $this->post;
    }

    private function selectPosts()
    {
        switch ($this->http->router->group()) {
            case 'post':
                $this->query->setQuery('post');
                break;
            case 'category':
                $catIdArray = RegistryFactory::start()
                    ->register('App\Resource\CategoryList')->child();
                $this->query->setQuery('post')
                    ->categoryId($catIdArray)
                    ->force();
                break;
            case 'date':
                $this->query->setQuery('post')
                    ->date($this->getDate())
                    ->force();
                break;
            default:
                $this->query->setQuery('post');
        }
        $this->post = $this->query->getQuery();
    }

    /**
     *
     * @return string
     */
    private function getDate(): string
    {
        $date = [
            $this->http->router->get('year'),
            $this->http->router->get('month'),
            $this->http->router->get('day'),
        ];
        return  implode('/', array_filter($date, function ($var) {
            return !in_array($var, ['', '/']);
        }));
    }
}
