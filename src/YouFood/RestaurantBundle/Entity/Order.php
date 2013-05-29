<?php

namespace YouFood\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YouFood\RestaurantBundle\Entity\Order
 *
 * @ORM\Table(name="yf_order")
 * @ORM\Entity
 */
class Order {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Table", inversedBy="orders")
     * @ORM\JoinColumn(name="table_id", referencedColumnName="id")
     */
    protected $table;

    /**
     * @ORM\ManyToMany(targetEntity="Menu")
     */
    protected $menus;

    /**
     * @ORM\OneToMany(targetEntity="OrderPlat", mappedBy="order", cascade={"persist"})
     */
    protected $orderPlats;

    /**
     * @ORM\ManyToOne(targetEntity="OrderStatus")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

   
    public function __construct()
    {
        $this->menus = new \Doctrine\Common\Collections\ArrayCollection();
    $this->orderPlats = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set table
     *
     * @param YouFood\RestaurantBundle\Entity\Table $table
     */
    public function setTable(\YouFood\RestaurantBundle\Entity\Table $table)
    {
        $this->table = $table;
    }

    /**
     * Get table
     *
     * @return YouFood\RestaurantBundle\Entity\Table 
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Add menus
     *
     * @param YouFood\RestaurantBundle\Entity\Menu $menus
     */
    public function addMenu(\YouFood\RestaurantBundle\Entity\Menu $menus)
    {
        $this->menus[] = $menus;
    }

    /**
     * Get menus
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Add orderPlats
     *
     * @param YouFood\RestaurantBundle\Entity\OrderPlat $orderPlats
     */
    public function addOrderPlat(\YouFood\RestaurantBundle\Entity\OrderPlat $orderPlats)
    {
        $this->orderPlats[] = $orderPlats;
    }

    /**
     * Get orderPlats
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOrderPlats()
    {
        return $this->orderPlats;
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