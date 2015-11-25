<?php

namespace Entity;

use Entity\Users;
use Doctrine\ORM\Mapping as ORM;

/**
 * Posts
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity
 */
class Posts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $categoryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="author_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $authorId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", precision=0, scale=0, nullable=false, unique=false)
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Posts
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set authorId
     *
     * @param integer $authorId
     *
     * @return Posts
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * Get authorId
     *
     * @return integer
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Posts
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate($format = "")
    {
        return $this->date->format( (empty($format) ? \Conf\Conf::instance()->getDateFormat() : $format));
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Posts
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return Posts
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Posts
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /* USERS */

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

    /* CATEGORIES */

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

