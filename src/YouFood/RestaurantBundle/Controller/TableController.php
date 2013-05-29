<?php

namespace YouFood\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use YouFood\RestaurantBundle\Entity\Zone;
use YouFood\RestaurantBundle\Entity\Table;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use YouFood\RestaurantBundle\Form\TableType;

class TableController extends Controller {

    public function createAction($idRestaurant, $idZone, Request $request) {

        $table = new Table();
        $form = $this->createForm(new TableType(), $table);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();

                $zone = new Zone();
                $zone = $this->getDoctrine()
                        ->getRepository('YouFoodRestaurantBundle:Zone')
                        ->find($idZone);

                $table->setZone($zone);

                $em->persist($table);
                $em->flush();

                return $this->redirect($this->generateUrl('Table_list', array(
                                    "idRestaurant" => $idRestaurant,
                                    "idZone" => $idZone,
                                )));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Table:create.html.twig', array(
                    'form' => $form->createView(),
                    'idRestaurant' => $idRestaurant,
                    'idZone' => $idZone,
                ));
    }

    public function updateAction(Request $request, $idTable) {

        $table = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Table')
                ->find($idTable);

        $form = $this->createForm(new TableType(), $table);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();
                $zone = $table->getZone();
                $restaurant = $zone->getRestaurant();
                return $this->redirect($this->generateUrl('Table_list', array('idRestaurant' => $restaurant->getId(),
                                    'idZone' => $zone->getId(),)));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Table:update.html.twig', array(
                    'form' => $form->createView(),
                    'idTable' => $idTable,
                ));
    }

    public function removeAction($idTable) {

        $entityManager = $this->getDoctrine()->getEntityManager();
        $table = $entityManager->getRepository('YouFoodRestaurantBundle:Table')
                ->find($idTable);

        if (!$table) {
            throw $this->createNotFoundException('No table found for id ' . $idTable);
        }

        $entityManager->remove($table);
        $entityManager->flush();

        $zone = $table->getZone();
        $restaurant = $zone->getRestaurant();
        return $this->redirect($this->generateUrl('Table_list', array('idRestaurant' => $restaurant->getId(),
                            'idZone' => $zone->getId(),)));
    }

    public function listAction($idRestaurant, $idZone, $_format) {

        
        if ($_format == 'html' && false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }
        
        $zoneRepository = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Zone');

        $tableRepository = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Table');

        $zone = $zoneRepository->find($idZone);
        $tables = $tableRepository->findByZone($zone->getId());

        return $this->render('YouFoodRestaurantBundle:Table:list.' . $_format . '.twig', array(
                    'tables' => $tables,
                    'idRestaurant' => $idRestaurant,
                    'idZone' => $idZone,
                ));
    }

}
