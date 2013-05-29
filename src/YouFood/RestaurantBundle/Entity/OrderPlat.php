<?php

namespace YouFood\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YouFood\RestaurantBundle\Entity\Restaurant
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class OrderPlat {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderPlats", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Plat")
     * @ORM\JoinColumn(name="plat_id", referencedColumnName="id")
     */
    private $plat;

    /**
     * @ORM\ManyToOne(targetEntity="OrderStatus")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;


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
     * Set order
     *
     * @param YouFood\RestaurantBundle\Entity\Order $order
     */
    public function setOrder(\YouFood\RestaurantBundle\Entity\Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return YouFood\RestaurantBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set plat
     *
     * @param YouFood\RestaurantBundle\Entity\Plat $plat
     */
    public function setPlat(\YouFood\RestaurantBundle\Entity\Plat $plat)
    {
        $this->plat = $plat;
    }

    /**
     * Get plat
     *
     * @return YouFood\RestaurantBundle\Entity\Plat 
     */
    public function getPlat()
    {
        return $this->plat;
    }

    /**
     * Set status
     *
     * @param YouFood\RestaurantBundle\Entity\OrderStatus $status
     */
    public function setStatus(\YouFood\RestaurantBundle\Entity\OrderStatus $status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return YouFood\RestaurantBundle\Entity\OrderStatus 
     */
    public function getStatus()
    {
        return $this->status;
    }
}