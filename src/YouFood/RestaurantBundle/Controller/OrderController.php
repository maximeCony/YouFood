<?php

namespace YouFood\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use YouFood\RestaurantBundle\Entity\Plat;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use YouFood\RestaurantBundle\Form\PlatType;
use YouFood\RestaurantBundle\Entity\Order;
use Doctrine\Common\Collections\ArrayCollection;

class OrderController extends Controller {

    public function createAction(Request $request, $idTable) {

        $xmlString = $request->request->get('xml');
        $xml = simplexml_load_string($xmlString);
        if (isset($xml->plats) && isset($xml->plats->plat)) {

            $orderStatus = $this->getDoctrine()
                            ->getRepository('YouFoodRestaurantBundle:OrderStatus')
                            ->find(1);
            
            $em = $this->getDoctrine()->getEntityManager();
            $order = new Order();

            foreach ($xml->plats->plat as $plat) {

                $idPlat = (string) $plat->attributes()->id;
                if ($idPlat != null) {

                    $plat = $this->getDoctrine()
                            ->getRepository('YouFoodRestaurantBundle:Plat')
                            ->find($idPlat);

                    if ($plat)
                        $orderPlat = new \YouFood\RestaurantBundle\Entity\OrderPlat();
                    $orderPlat->setPlat($plat);
                    $orderPlat->setOrder($order);
                    $orderPlat->setStatus($orderStatus);
                    $order->addOrderPlat($orderPlat);
                }
            }
            $table = $this->getDoctrine()
                    ->getRepository('YouFoodRestaurantBundle:Table')
                    ->find($idTable);

            if ($idTable) {

                $order->setTable($table);
                $order->setStatus($orderStatus);
                $em->persist($order);
                $table->addOrder($order);
                $em->flush();
            }
        }
        return new Response("ok");
    }

    public function listOrderedAction($idRestaurant) {

       $query = $this->getDoctrine()
                ->getEntityManager()
                ->createQuery('
            SELECT op FROM YouFoodRestaurantBundle:OrderPlat op
            JOIN op.order o
            JOIN o.table t
            JOIN t.zone z
            JOIN z.restaurant r
            JOIN op.status ops
            WHERE r.id = :idRestaurant AND ops.id = 1')
                ->setParameter('idRestaurant', $idRestaurant);

        $orderPlats = $query->getResult();

        return $this->render('YouFoodRestaurantBundle:Order:listOrdered.xml.twig', array(
                    'orderPlats' => $orderPlats,
                ));
    }
    
     public function orderPlatPreparedAction($idOrderPlat) {
         
          $orderPlat = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:OrderPlat')
                ->find($idOrderPlat);
          
          $orderStatus = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:OrderStatus')
                ->find(2);
          
          $orderPlat->setStatus($orderStatus);
          
          $this->getDoctrine()->getEntityManager()->flush();
          
          return new Response("ok");
     }
     
     public function orderPlatServedAction($idOrderPlat) {
         
          $orderPlat = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:OrderPlat')
                ->find($idOrderPlat);
          
          $orderStatus = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:OrderStatus')
                ->find(3);
          
          $orderPlat->setStatus($orderStatus);
          
          $this->getDoctrine()->getEntityManager()->flush();
          
          return new Response("ok");
     }

}
