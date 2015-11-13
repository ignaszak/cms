<?php

namespace Entity;
use Entity\Users;

/**
 * Posts
 *
 * @Table(name="posts")
 * @Entity
 */
class Posts
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @Column(name="category_id", type="integer", nullable=false)
     */
    private $category_id = '0';

    /**
     * @var integer
     *
     * @Column(name="author_id", type="integer", nullable=false)
     */
    private $author_id = '0';

    /**
     * @var \DateTime
     *
     * @Column(name="date", type="datetime", nullable=false)
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @Column(name="alias", type="string", length=255, nullable=false)
     */
    private $alias;

    /**
     * @var string
     *
     * @Column(name="content", type="text", nullable=false)
     */
    private $content;
    
    /**
     * @ManyToOne(targetEntity="Entity\Users")
     * @JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     */
    private $user;
    
    /**
     * @ManyToOne(targetEntity="Entity\Categories")
     * @JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;
    
    /**
     * @ManyToOne(targetEntity="Entity\Categories", inversedBy="post")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $categories;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getPostId()
    {
        return $this->id;
    }

    /**
     * Set category_id
     *
     * @param integer $category_id
     * @return Posts
     */
    public function setPostCategoryId($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getPostCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set author_id
     *
     * @param integer $author_id
     * @return Posts
     */
    public function setPostAuthorId($author_id)
    {
        $this->author_id = $author_id;

        return $this;
    }

    /**
     * Get author_id
     *
     * @return integer 
     */
    public function getPostAuthorId()
    {
        return $this->author_id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Posts
     */
    public function setPostDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @param $format
     * @return \DateTime 
     */
    public function getPostDate($format = "")
    {
        return $this->date->format( (empty($format) ? \Conf\Conf::instance()->getDateFormat() : $format));
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Posts
     */
    public function setPostTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getPostTitle()
    {
        return $this->title;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return Posts
     */
    public function setPostAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getPostAlias()
    {
        return $this->alias;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Posts
     */
    public function setPostContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getPostContent()
    {
        return $this->content;
    }
    
    ////////////// USERS
    
    /**
     * Get login
     *
     * @return string
     */
    public function getUserLogin()
    {
        return $this->user->getLogin();
    }
    
    /**
     * Get email
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user->getEmail();
    }
    
    /**
     * Get role
     *
     * @return string
     */
    public function getUserRole()
    {
        return $this->user->getRole();
    }
    
    ////////////// CATEGORIES
    
    /**
     * Get categoryParentID
     *
     * @return string
     */
    public function getCategoryParentID()
    {
        return $this->category->getCategoryParentID();
    }
    
    /**
     * Get categoryTitle
     *
     * @return string
     */
    public function getCategoryTitle()
    {
        return $this->category->getCategoryTitle();
    }
    
    /**
     * Get categoryAlias
     *
     * @return string
     */
    public function getCategoryAlias()
    {
        return $this->category->getCategoryAlias();
    }
}
