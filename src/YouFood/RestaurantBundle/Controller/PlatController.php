<?php

namespace YouFood\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use YouFood\RestaurantBundle\Entity\Plat;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use YouFood\RestaurantBundle\Form\PlatType;

class PlatController extends Controller {

    public function createAction(Request $request) {

        $plat = new Plat();
        $form = $this->createForm(new PlatType(), $plat);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($plat);
                $em->flush();

                return $this->redirect($this->generateUrl('Plat_list'));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Plat:create.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

    public function listAction($_format) {

        if ($_format == 'html' && false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }        
        $plats = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Plat')
                ->findAll();

        return $this->render('YouFoodRestaurantBundle:Plat:list.' . $_format . '.twig', array(
                    'plats' => $plats,
                ));
    }
    
    
    public function updateAction(Request $request, $idPlat) {

        $plat = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Plat')
                ->find($idPlat);

        $form = $this->createForm(new PlatType(), $plat);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();
                return $this->redirect($this->generateUrl('Plat_list'));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Plat:update.html.twig', array(
                    'form' => $form->createView(),
                    'idPlat' => $idPlat,
                ));
    }

    public function removeAction($idPlat) {

        $entityManager = $this->getDoctrine()->getEntityManager();
        $plat = $entityManager->getRepository('YouFoodRestaurantBundle:Plat')
                ->find($idPlat);

        if (!$plat) {
            throw $this->createNotFoundException('No plat found for id ' . $idPlat);
        }

        $entityManager->remove($plat);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('Plat_list'));
    }

}
