<?php

namespace YouFood\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use YouFood\RestaurantBundle\Entity\Restaurant;
use YouFood\RestaurantBundle\Entity\Zone;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use YouFood\RestaurantBundle\Form\ZoneType;

class ZoneController extends Controller {
    
    public function createAction($idRestaurant, Request $request) {

        $zone = new Zone();
        $form = $this->createForm(new ZoneType(), $zone);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();

                $restaurant = new Restaurant();
                $restaurant = $this->getDoctrine()
                        ->getRepository('YouFoodRestaurantBundle:Restaurant')
                        ->find($idRestaurant);

                $zone->setRestaurant($restaurant);

                $em->persist($zone);
                $em->flush();

                return $this->redirect($this->generateUrl('Restaurant_manage', array('idRestaurant' =>$idRestaurant,)));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Zone:create.html.twig', array(
                    'form' => $form->createView(),
                    'idRestaurant' => $idRestaurant,
                ));
    }

    public function listAction($idRestaurant, $_format) {

        if ($_format == 'html' && false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }
        
        $restaurantRepository = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Restaurant');

        $zoneRepository = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Zone');

        $restaurant = $restaurantRepository->find($idRestaurant);
        $zones = $zoneRepository->findByRestaurant($restaurant->getId());

         return $this->render('YouFoodRestaurantBundle:Zone:list.'.$_format.'.twig', array(
                        'idRestaurant' => $idRestaurant,
                        'zones' => $zones,
                    ));
    }
    
    public function updateAction(Request $request, $idZone) {

        $zone = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Zone')
                ->find($idZone);

        $form = $this->createForm(new ZoneType(), $zone);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();
                return $this->redirect($this->generateUrl('Restaurant_manage', array('idRestaurant' => $zone->getRestaurant()->getId(),)));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Zone:update.html.twig', array(
                    'form' => $form->createView(),
                    'idZone' => $idZone,
                ));
    }
    
    public function removeAction($idRestaurant, $idZone){
        
        $zone = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Zone')
                ->find($idZone);
        if($zone) {
            $em = $this->getDoctrine()
                    ->getEntityManager();
            $em->remove($zone);
            $em->flush();
            
            return $this->redirect($this->generateUrl('Restaurant_manage', array('idRestaurant' =>$idRestaurant,)));
        }
    }

}
