<?php

namespace YouFood\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use YouFood\RestaurantBundle\Entity\Restaurant;
use YouFood\RestaurantBundle\Entity\Waiter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use YouFood\RestaurantBundle\Form\WaiterType;

class WaiterController extends Controller {

    public function createAction($idRestaurant, Request $request) {

        $waiter = new Waiter();
        $form = $this->createForm(new WaiterType(), $waiter);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $restaurant = $this->getDoctrine()
                        ->getRepository('YouFoodRestaurantBundle:Restaurant')
                        ->find($idRestaurant);
                $waiter->setRestaurant($restaurant);

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($waiter);
                $em->flush();

                return $this->redirect($this->generateUrl('Restaurant_manage', array("idRestaurant" => $idRestaurant)));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Waiter:create.html.twig', array(
                    'form' => $form->createView(),
                    'idRestaurant' => $idRestaurant,
                ));
    }

    public function updateAction(Request $request, $idWaiter) {

        $waiter = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Waiter')
                ->find($idWaiter);

        $form = $this->createForm(new WaiterType(), $waiter);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();
                return $this->redirect($this->generateUrl('Restaurant_manage', array('idRestaurant' => $waiter->getRestaurant()->getId(),)));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Waiter:update.html.twig', array(
                    'form' => $form->createView(),
                    'idWaiter' => $idWaiter,
                ));
    }

    public function removeAction($idWaiter) {

        $entityManager = $this->getDoctrine()->getEntityManager();
        $waiter = $entityManager->getRepository('YouFoodRestaurantBundle:Waiter')
                ->find($idWaiter);

        if (!$waiter) {
            throw $this->createNotFoundException('No waiter found for id ' . $idWaiter);
        }

        $entityManager->remove($waiter);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('Waiter_list'));
    }

    public function listAction($idRestaurant, $_format) {

        if ($_format == 'html' && false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }
        
        $query = $this->getDoctrine()
                ->getEntityManager()
                ->createQuery('
            SELECT w FROM YouFoodRestaurantBundle:Waiter w
            JOIN w.restaurant r
            WHERE r.id = :idRestaurant')
                ->setParameter('idRestaurant', $idRestaurant);

        $waiters = $query->getResult();

        return $this->render('YouFoodRestaurantBundle:Waiter:list.' . $_format . '.twig', array(
                    'idRestaurant' => $idRestaurant,
                    'waiters' => $waiters,
                ));
    }

    public function todoAction($idWaiter) {

        $query = $this->getDoctrine()
                ->getEntityManager()
                ->createQuery('
            SELECT o FROM YouFoodRestaurantBundle:Order o
            JOIN o.table t
            JOIN t.zone z
            JOIN z.waiter w
            JOIN o.status s
            WHERE w.id = :id AND s.id = 2')
                ->setParameter('id', $idWaiter);

        $orders = $query->getResult();

        $callWaiters = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:CallWaiter')
                ->findByWaiter($idWaiter);


        return $this->render('YouFoodRestaurantBundle:Waiter:todo.xml.twig', array(
                    'orders' => $orders,
                    'callWaiters' => $callWaiters,
                ));
    }

    public function callAction($idTable) {

        $table = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Table')
                ->find($idTable);

        $callWaiter = new \YouFood\RestaurantBundle\Entity\CallWaiter();
        $callWaiter->setTable($table);
        $callWaiter->setWaiter($table->getZone()->getWaiter());

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($callWaiter);
        $em->flush();
        return new Response("ok");
    }

    public function removeCallAction($idTable, $idWaiter) {

        $query = $this->getDoctrine()
                ->getEntityManager()
                ->createQuery('
            SELECT cw FROM YouFoodRestaurantBundle:CallWaiter cw
            JOIN cw.table t
            JOIN cw.waiter w
            WHERE w.id = :idWaiter AND t.id = :idTable')
                ->setParameter('idTable', $idTable)
                ->setParameter('idWaiter', $idWaiter);

        $callWaiters = $query->getResult();

        $em = $this->getDoctrine()->getEntityManager();
        foreach ($callWaiters as $callWaiter) {
            $em->remove($callWaiter);
        }
        $em->flush();
        return new Response("ok");
    }

}
