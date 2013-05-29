<?php

namespace YouFood\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YouFood\RestaurantBundle\Entity\Waiter
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Waiter {

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
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     */
    protected $restaurant;

    /**
     * @ORM\OneToOne(targetEntity="Zone", mappedBy="waiter", cascade={"persist", "remove"})
     */
    private $zone;

    /**
     * @ORM\OneToMany(targetEntity="CallWaiter", mappedBy="waiter")
     */
    protected $callWaiters;

    public function __construct() {
        $this->callWaiters = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set zone
     *
     * @param YouFood\RestaurantBundle\Entity\Zone $zone
     */
    public function setZone(\YouFood\RestaurantBundle\Entity\Zone $zone) {
        $this->zone = $zone;
    }

    /**
     * Get zone
     *
     * @return YouFood\RestaurantBundle\Entity\Zone 
     */
    public function getZone() {
        return $this->zone;
    }

    /**
     * Add callWaiters
     *
     * @param YouFood\RestaurantBundle\Entity\CallWaiter $callWaiters
     */
    public function addCallWaiter(\YouFood\RestaurantBundle\Entity\CallWaiter $callWaiters) {
        $this->callWaiters[] = $callWaiters;
    }

    /**
     * Get callWaiters
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCallWaiters() {
        return $this->callWaiters;
    }


    /**
     * Set restaurant
     *
     * @param YouFood\RestaurantBundle\Entity\Restaurant $restaurant
     */
    public function setRestaurant(\YouFood\RestaurantBundle\Entity\Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * Get restaurant
     *
     * @return YouFood\RestaurantBundle\Entity\Restaurant 
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }
}