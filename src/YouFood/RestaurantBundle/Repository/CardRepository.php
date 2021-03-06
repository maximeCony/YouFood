<?php

namespace YouFood\RestaurantBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * RemoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CardRepository extends EntityRepository {

	/*
	* Set the card as offline
	*/
    public function setCardOffline() {

        $query = $this->createQueryBuilder('card')
                ->update()
                ->set('card.current', 0)
                ->where('card.current = 1')
                ->getQuery();
        
        $query->execute();
    }

}