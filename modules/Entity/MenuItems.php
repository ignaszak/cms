<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuItems
 *
 * @ORM\Table(name="menu_items", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class MenuItems
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
     * @ORM\Column(name="menu_id", type="integer", nullable=false)
     */
    private $menuId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\ManyToOne(targetEntity="Entity\Menus", inversedBy="menuItems")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id", nullable=true)
     */
    private $menu;

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
     * Set menuId
     *
     * @param string $name
     *
     * @return Menus
     */
    public function setMenuId($menuId)
    {
        $this->menuId = $menuId;

        return $this;
    }

    /**
     * Get menuId
     *
     * @return string
     */
    public function getMenuId()
    {
        return $this->menuId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return MenuItems
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
     * Set adress
     *
     * @param string $adress
     *
     * @return MenuItems
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set menu
     *
     * @param Menus $adress
     *
     * @return MenuItems
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return Menus
     */
    public function getMenu()
    {
        return $this->menu;
    }

}

