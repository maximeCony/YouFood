<?php

namespace YouFood\RestaurantBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @ORM\Table(name="yf_users")
 * @ORM\Entity(repositoryClass="YouFood\RestaurantBundle\Repository\UserRepository")
 */
class User implements UserInterface {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     *
     */
    private $groups;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     */
    private $restaurant;

    public function __construct() {

        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        $this->groups = new ArrayCollection();
    }

    public function __sleep() {
        return array('id');
    }

    public function getRolesAsArray() {

        $roles = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($this->groups as $group) {
            $roles->add($group->getRole());
        }
        return $roles;
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {

        return $this->groups->toArray();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        
    }

    /**
     * @inheritDoc
     */
    public function equals(UserInterface $user) {
        return $this->username === $user->getUsername();
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
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt) {
        $this->salt = $salt;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * Add groups
     *
     * @param YouFood\RestaurantBundle\Entity\Group $groups
     */
    public function addGroup(\YouFood\RestaurantBundle\Entity\Group $groups) {
        $this->groups[] = $groups;
    }

    /**
     * Get groups
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGroups() {
        return $this->groups;
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

}