<?php

namespace YouFood\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YouFood\RestaurantBundle\Entity\Restaurant
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CallWaiter {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Waiter", inversedBy="callWaiters")
     * @ORM\JoinColumn(name="waiter_id", referencedColumnName="id")
     */
    protected $waiter;

    /**
     * @ORM\ManyToOne(targetEntity="Table")
     * @ORM\JoinColumn(name="table_id", referencedColumnName="id")
     */
    private $table;


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
     * Set waiter
     *
     * @param YouFood\RestaurantBundle\Entity\Waiter $waiter
     */
    public function setWaiter(\YouFood\RestaurantBundle\Entity\Waiter $waiter)
    {
        $this->waiter = $waiter;
    }

    /**
     * Get waiter
     *
     * @return YouFood\RestaurantBundle\Entity\Waiter 
     */
    public function getWaiter()
    {
        return $this->waiter;
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
}