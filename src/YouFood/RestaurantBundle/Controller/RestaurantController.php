<?php

namespace YouFood\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use YouFood\RestaurantBundle\Entity\Restaurant;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use YouFood\RestaurantBundle\Form\RestaurantType;

class RestaurantController extends Controller {

    public function createAction(Request $request) {

        $restaurant = new Restaurant();
        $form = $this->createForm(new RestaurantType(), $restaurant);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($restaurant);
                $em->flush();

                return $this->redirect($this->generateUrl('Restaurant_list'));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Restaurant:create.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

    public function updateAction(Request $request, $idRestaurant) {

        $restaurant = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Restaurant')
                ->find($idRestaurant);

        $form = $this->createForm(new REstaurantType(), $restaurant);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();
                return $this->redirect($this->generateUrl('Restaurant_list'));
            }
        }
        return $this->render('YouFoodRestaurantBundle:Restaurant:update.html.twig', array(
                    'form' => $form->createView(),
                    'idRestaurant' => $idRestaurant,
                ));
    }

    public function listAction($_format) {

        if ($_format == 'html' && false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }

        $restaurants = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Restaurant')
                ->findAll();

        return $this->render('YouFoodRestaurantBundle:Restaurant:list.' . $_format . '.twig', array(
                    'restaurants' => $restaurants,
                ));
    }

    public function manageAction($idRestaurant) {
        
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }

        $restaurant = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Restaurant')
                ->find($idRestaurant);


        return $this->render('YouFoodRestaurantBundle:Restaurant:manage.html.twig', array(
                    'idRestaurant' => $restaurant->getId(),
                ));
    }

    public function removeAction($idRestaurant) {

        $entityManager = $this->getDoctrine()->getEntityManager();
        $repository = $entityManager->getRepository('YouFoodRestaurantBundle:Restaurant');
        $restaurant = $repository->find($idRestaurant);

        if (!$restaurant) {
            throw $this->createNotFoundException('No restaurant found for id ' . $idRestaurant);
        }

        $entityManager->remove($restaurant);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('Restaurant_list'));
    }

}
