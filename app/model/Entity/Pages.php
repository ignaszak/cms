<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Entity\Controller\IPagesQuery;
use Entity\Users;
use Ignaszak\Registry\RegistryFactory;

/**
 * Pages
 *
 * @ORM\Table(name="pages", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="FK_PAGE_USER", columns={"author_id"})})
 * @ORM\Entity
 */
class Pages extends IPagesQuery
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255, nullable=true)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="public", type="integer", nullable=true)
     */
    private $public;

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
     * Set authorId
     *
     * @param integer $authorId
     *
     * @return Pages
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
     * @return Pages
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
     * @return Pages
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
     * @return Pages
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
     * @return Pages
     */
    public function setQuery($content)
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
     * @return Pages
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
     * @return Pages
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
}
