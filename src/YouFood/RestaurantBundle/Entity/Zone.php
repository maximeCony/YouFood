<?php

namespace YouFood\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YouFood\RestaurantBundle\Entity\Restaurant
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Zone {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="zones")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     */
    protected $restaurant;

    /**
     * @ORM\OneToOne(targetEntity="Waiter", inversedBy="zone")
     * @ORM\JoinColumn(name="waiter_id", referencedColumnName="id")
     */
    protected $waiter;

    /**
     * @ORM\OneToMany(targetEntity="Table", mappedBy="zone", cascade={"persist", "remove"})
     */
    protected $tables;

    public function __construct() {
        $this->tables = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set restaurant
     *
     * @param YouFood\RestaurantBundle\Entity\Restaurant $restaurant
     */
    public function setRestaurant(\YouFood\RestaurantBundle\Entity\Restaurant $restaurant) {
        $this->restaurant = $restaurant;
    }

    /**
     * Get restaurant
     *
     * @return YouFood\RestaurantBundle\Entity\Restaurant 
     */
    public function getRestaurant() {
        return $this->restaurant;
    }

    /**
     * Set waiter
     *
     * @param YouFood\RestaurantBundle\Entity\Waiter $waiter
     */
    public function setWaiter(\YouFood\RestaurantBundle\Entity\Waiter $waiter) {
        $this->waiter = $waiter;
    }

    /**
     * Get waiter
     *
     * @return YouFood\RestaurantBundle\Entity\Waiter 
     */
    public function getWaiter() {
        return $this->waiter;
    }

    /**
     * Add tables
     *
     * @param YouFood\RestaurantBundle\Entity\Table $tables
     */
    public function addTable(\YouFood\RestaurantBundle\Entity\Table $tables) {
        $this->tables[] = $tables;
    }

    /**
     * Get tables
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTables() {
        return $this->tables;
    }

}