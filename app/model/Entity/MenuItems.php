<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuItems
 *
 * @ORM\Table(name="menu_items", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="FK_MENU_ITEMS_MENU", columns={"menu_id"})})
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
     * @ORM\Column(name="sequence", type="integer", nullable=false)
     */
    private $sequence;

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
     * @var \Entity\Menus
     *
     * @ORM\ManyToOne(targetEntity="Entity\Menus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     * })
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
     * @param string $menuId
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
     * Set sequence
     *
     * @param string $order
     *
     * @return Menus
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get sequence
     *
     * @return string
     */
    public function getSequence()
    {
        return $this->sequence;
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
     * @param Menus $menu
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
