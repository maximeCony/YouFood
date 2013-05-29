<?php

namespace YouFood\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * YouFood\RestaurantBundle\Entity\Card
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="YouFood\RestaurantBundle\Repository\CardRepository")
 */
class Card {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean $current
     *
     * @ORM\Column(name="current", type="boolean")
     */
    private $current;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Menu")
     */
    protected $menus;

    /**
     * @ORM\ManyToMany(targetEntity="Plat")
     */
    protected $plats;

    public function __construct() {
        $this->menus = new \Doctrine\Common\Collections\ArrayCollection();
        $this->plats = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set current
     *
     * @param boolean $current
     */
    public function setCurrent($current) {
        $this->current = $current;
    }

    /**
     * Get current
     *
     * @return boolean 
     */
    public function getCurrent() {
        return $this->current;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Add menus
     *
     * @param YouFood\RestaurantBundle\Entity\Menu $menus
     */
    public function addMenu(\YouFood\RestaurantBundle\Entity\Menu $menus) {
        $this->menus[] = $menus;
    }

    /**
     * Get menus
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMenus() {
        return $this->menus;
    }

    /**
     * Add plats
     *
     * @param YouFood\RestaurantBundle\Entity\Plat $plats
     */
    public function addPlat(\YouFood\RestaurantBundle\Entity\Plat $plats) {
        $this->plats[] = $plats;
    }

    /**
     * Get plats
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPlats() {
        return $this->plats;
    }


    /**
     * Set menus
     *
     * @param string $menus
     */
    public function setMenus($menus)
    {
        $this->menus = $menus;
    }

    /**
     * Set plats
     *
     * @param string $plats
     */
    public function setPlats($plats)
    {
        $this->plats = $plats;
    }
}