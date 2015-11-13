<?php

namespace Entity;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Categories
 *
 * @Table(name="categories")
 * @Entity
 */
class Categories
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
     * @Column(name="parent_id", type="integer", nullable=true)
     */
    private $parent_id;

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
     * @OneToMany(targetEntity="Entity\Posts", mappedBy="categories")
     */
    private $post;

    public function __construct() {
        $this->post = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->id;
    }

    /**
     * Set parent_id
     *
     * @param integer $parent_id
     * @return Categories
     */
    public function setCategoryParentId($parent_id)
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    /**
     * Get parent_id
     *
     * @return integer 
     */
    public function getCategoryParentId()
    {
        return $this->parent_id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Categories
     */
    public function setCategoryTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getCategoryTitle()
    {
        return $this->title;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return Categories
     */
    public function setCategoryAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getCategoryAlias()
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
        return $this->post;
    }
}
