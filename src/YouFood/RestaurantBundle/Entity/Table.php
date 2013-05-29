<?php

namespace YouFood\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YouFood\RestaurantBundle\Entity\Table
 *
 * @ORM\Table(name="yf_table")
 * @ORM\Entity
 */
class Table
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
     * @ORM\ManyToOne(targetEntity="Zone", inversedBy="tables")
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id")
     */
    protected $zone;
    
    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="table", cascade={"persist", "remove"})
     */
    protected $orders;

    public function __construct($id = null)
    {
        if($id != null) {
            $this->id = $id;
        }
        
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set zone
     *
     * @param YouFood\RestaurantBundle\Entity\Zone $zone
     */
    public function setZone(\YouFood\RestaurantBundle\Entity\Zone $zone)
    {
        $this->zone = $zone;
    }

    /**
     * Get zone
     *
     * @return YouFood\RestaurantBundle\Entity\Zone 
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Add orders
     *
     * @param YouFood\RestaurantBundle\Entity\Order $orders
     */
    public function addOrder(\YouFood\RestaurantBundle\Entity\Order $orders)
    {
        $this->orders[] = $orders;
    }

    /**
     * Get orders
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }
}