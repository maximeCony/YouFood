<?php

namespace YouFood\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YouFood\RestaurantBundle\Entity\Table
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class OrderStatus
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
    private $label;

     public function __construct($id = null) {
       
         if($id != null) {
             $this->id = $id;
         }
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
     * Set label
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }
}