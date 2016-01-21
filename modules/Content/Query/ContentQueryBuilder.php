<?php
namespace Content\Query;

use Conf\DB\DBDoctrine;

class ContentQueryBuilder implements IContentQueryBuilder
{

    /**
     *
     * @var IContentQueryController
     */
    private $_contentQueryController;

    /**
     *
     * @param IContentQueryController $_contentQueryController
     */
    public function __construct(IContentQueryController $_contentQueryController)
    {
        $this->_contentQueryController = $_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::id($value)
     */
    public function id($value): IContentQueryController
    {
        $this->set('c.id', $value);
        return $this->_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::categoryId($value)
     */
    public function categoryId($value): IContentQueryController
    {
        $this->set('c.categoryId', $value);
        return $this->_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::categoryAlias($value)
     */
    public function categoryAlias(string $value): IContentQueryController
    {
        $column = 'category.alias';
        $this->join($column);
        $this->set($column, $value);
        return $this->_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::authorId($value)
     */
    public function authorId($value): IContentQueryController
    {
        $this->set('c.authorId', $value);
        return $this->_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::authorLogin($value)
     */
    public function authorLogin(string $value): IContentQueryController
    {
        $column = 'user.login';
        $this->join($column);
        $this->set($column, $value);
        return $this->_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::date($value)
     */
    public function date(string $value): IContentQueryController
    {
        $date = explode('-', $value);
        
        $emConfig = DBDoctrine::em()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('DATE_FORMAT', 'DoctrineExtensions\Query\Mysql\DateFormat');
        
        $format = "";
        if (array_key_exists(0, $date)) {
            $format = "%Y";
        }
        if (array_key_exists(1, $date)) {
            $format .= "-%m";
        }
        if (array_key_exists(2, $date)) {
            $format .= "-%d";
        }
        
        $this->set('DATE_FORMAT(c.date, \'' . $format . '\')', $value);
        
        return $this->_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::title($value)
     */
    public function title(string $value): IContentQueryController
    {
        $this->set('c.title', $value);
        return $this->_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::alias($value)
     */
    public function alias(string $value): IContentQueryController
    {
        $this->set('c.alias', $value);
        return $this->_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::contentLike($value)
     */
    public function contentLike(string $value): IContentQueryController
    {
        $this->like('content', $value);
        return $this->_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::titleLike($value)
     */
    public function titleLike(string $value): IContentQueryController
    {
        $this->like('title', $value);
        return $this->_contentQueryController;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Content\Query\IContentQueryBuilder::findBy($column, $value)
     */
    public function findBy(string $column, string $value): IContentQueryController
    {
        $this->set('c.' . $column, $value);
        return $this->_contentQueryController;
    }

    /**
     *
     * @param string $column
     * @param string $value
     */
    private function like(string $column, string $value)
    {
        $query = $this->_contentQueryController->contentQuery->andwhere('c.' . $column . ' LIKE :value')->setParameter('value', '%' . $value . '%');
        $this->_contentQueryController->setContentQuery($query);
    }

    /**
     *
     * @param string $column
     */
    private function join(string $column)
    {
        $reference = $this->getReference($column);
        
        $query = $this->_contentQueryController->contentQuery->join('c.' . $reference, $reference);
        
        $this->_contentQueryController->setContentQuery($query);
    }

    /**
     *
     * @param string $column
     * @param mixed $value
     */
    private function set(string $column, $value)
    {
        $query = $this->_contentQueryController->contentQuery->andwhere($column . ' IN(:value)')->setParameter('value', $value);
        
        $this->_contentQueryController->setContentQuery($query);
    }

    /**
     *
     * @param string $column
     *            $return string
     */
    private function getReference(string $column): string
    {
        $array = explode('.', $column);
        return $array[0];
    }
}
