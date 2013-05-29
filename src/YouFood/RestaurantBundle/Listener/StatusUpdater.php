<?php

namespace YouFood\RestaurantBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;

class StatusUpdater {

    public function postUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceof \YouFood\RestaurantBundle\Entity\OrderPlat) {

            $order = $entity->getOrder();
            if ($order) {
                $orderPlats = $order->getOrderPlats();
                if ($orderPlats) {

                    $orderStatusId = null;
                    foreach ($orderPlats as $orderPlat) {
                        
                        if ($orderStatusId == null) {
                            //set the first orderStatus
                            $orderStatusId = $orderPlat->getStatus()->getId();
                        } else if ($orderStatusId != $orderPlat->getStatus()->getId()) {
                            //return if one of the orderStatus is diffrent of the others
                            return;
                        }
                    }
                    $orderStatus = $em->getRepository('YouFoodRestaurantBundle:OrderStatus')
                            ->find($orderStatusId);

                    $order->setStatus($orderStatus);
                    $em->flush();
                }
            }
        }
    }

}