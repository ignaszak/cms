<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Categories
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity
 */
class Categories
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var integer @ORM\Column(name="parent_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $parentId;

    /**
     *
     * @var string @ORM\Column(name="title", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $title;

    /**
     *
     * @var string @ORM\Column(name="alias", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $alias;

    /**
     * @ORM\OneToMany(targetEntity="Entity\Posts", mappedBy="categories")
     */
    private $post;

    public function __construct()
    {
        $this->post = new ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return integer
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

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
     * Set parentId
     *
     * @param string $parentId
     *
     * @return Categories
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        
        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Categories
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
     * @return Categories
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
     * Get posts
     *
     * @return string
     */
    public function getPost()
    {
        $iterator = $this->post->getIterator();
        $iterator->uasort(function ($a, $b) {
            return $b->getId() <=> $a->getId();
        });
        return $iterator;
    }
}
