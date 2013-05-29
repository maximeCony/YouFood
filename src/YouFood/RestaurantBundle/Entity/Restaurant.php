<?php

namespace YouFood\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * YouFood\RestaurantBundle\Entity\Restaurant
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Restaurant
{
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
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Zone", mappedBy="restaurant", cascade={"persist", "remove"})
     */
    private $zones;

    
    public function __construct()
    {
        $this->zones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add zones
     *
     * @param YouFood\RestaurantBundle\Entity\Zone $zones
     */
    public function addZone(\YouFood\RestaurantBundle\Entity\Zone $zones)
    {
        $this->zones[] = $zones;
    }

    /**
     * Get zones
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getZones()
    {
        return $this->zones;
    }
}