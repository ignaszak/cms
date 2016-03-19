<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Entity\Controller\IPostsQuery;
use Entity\Users;
use Ignaszak\Registry\RegistryFactory;

/**
 * Posts
 *
 * @ORM\Table(name="posts", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="FK_POST_CAT", columns={"category_id"}), @ORM\Index(name="FK_POST_USER", columns={"author_id"})})
 * @ORM\Entity
 */
class Posts extends IPostsQuery
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="author_id", type="integer", nullable=false)
     */
    private $authorId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255, nullable=false)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="public", type="integer", nullable=false)
     */
    private $public;

    /**
     * @var \Entity\Categories
     *
     * @ORM\ManyToOne(targetEntity="Entity\Categories", inversedBy="post")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $categories;

    /**
     * @var \Entity\Categories
     *
     * @ORM\ManyToOne(targetEntity="Entity\Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     * })
     */
    private $author;

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
        if ($format == "DateTime") {
            return $this->date;
        } else {
            $dateFormat = RegistryFactory::start('file')->register('Conf\Conf')
                ->getDateFormat();
            return $this->date->format((empty($format) ? $dateFormat : $format));
        }
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
     * Set public
     *
     * @param integer $public
     *
     * @return Posts
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return integer
     */
    public function getPublic()
    {
        return $this->public;
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
        return $this->author = $author;

        return $this;
    }

    /**
     * Get Users object
     *
     * @return Users
     */
    public function getAuthor()
    {
        return $this->author;
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
