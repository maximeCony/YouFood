<?php

namespace YouFood\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YouFood\RestaurantBundle\Entity\Restaurant
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Menu
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
     * @ORM\ManyToMany(targetEntity="Plat")
     */
    protected $plats;
    

    public function __construct()
    {
        $this->plats = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add plats
     *
     * @param YouFood\RestaurantBundle\Entity\Plat $plats
     */
    public function addPlat(\YouFood\RestaurantBundle\Entity\Plat $plats)
    {
        $this->plats[] = $plats;
    }

    /**
     * Get plats
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPlats()
    {
        return $this->plats;
    }
}