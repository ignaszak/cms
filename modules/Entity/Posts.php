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
     * @ORM\ManyToOne(targetEntity="Entity\Users", cascade={"persist"})
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Entity\Categories", inversedBy="post")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="Entity\Categories", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;

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

    /**
     * Set Users object
     *
     * @param Users $author
     *
     * @return Posts
     */
    public function setAuthor($author)
    {
        return $this->user = $author;

        return $this;
    }

    /**
     * Get Users object
     *
     * @return Users
     */
    public function getAuthor()
    {
        return $this->user;
    }

    /**
     * Set Categories object
     *
     * @param Categories $category
     *
     * @return Posts
     */
    public function setCategory($category)
    {
        return $this->category = $category;

        return $this;
    }

    /**
     * Get Categories object
     *
     * @return Categories
     */
    public function getCategory()
    {
        return $this->category;
    }

}

