<?php

namespace YouFood\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use YouFood\RestaurantBundle\Entity\Card;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use YouFood\RestaurantBundle\Form\CardType;

class CardController extends Controller {

    public function createAction(Request $request) {
        
        $card = new Card();
        $form = $this->createForm(new CardType(), $card);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                
                if($card->getCurrent()) {
                
                    $this->getDoctrine()
                        ->getRepository('YouFoodRestaurantBundle:Card')
                        ->setCardOffline();
                }                
                $em->persist($card);
                $em->flush();

                return $this->redirect($this->generateUrl('Card_list'));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Card:create.html.twig', array(
                    'form' => $form->createView(),
                ));
    }
    
    public function updateAction(Request $request, $idCard) {

        $card = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Card')
                ->find($idCard);

        $form = $this->createForm(new CardType(), $card);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                if($card->getCurrent()) {
                
                    $this->getDoctrine()
                        ->getRepository('YouFoodRestaurantBundle:Card')
                        ->setCardOffline();
                }
                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();
                return $this->redirect($this->generateUrl('Card_list'));
            }
        }

        return $this->render('YouFoodRestaurantBundle:Card:update.html.twig', array(
                    'form' => $form->createView(),
                    'idCard' => $idCard,
                ));
    }
    
    
     public function listAction() {
         
         if (false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }
        
        $repository = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Card');

        $cards = $repository->findAll();

        return $this->render('YouFoodRestaurantBundle:Card:list.html.twig', array(
                    'cards' => $cards,
                ));
    }
    
    public function currentAction() {

        $repository = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Card');

        $card = $repository->findOneByCurrent(1);

        return $this->render('YouFoodRestaurantBundle:Card:current.xml.twig', array(
                    'card' => $card,
                ));
    }
    
    public function setCurrentAction($idCard) {

        $cards = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Card')
                ->findByCurrent(1);
        
        $card = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:Card')
                ->find($idCard);

        foreach ($cards as $cardd) {
            $cardd->setCurrent(0);
        }
        $card->setCurrent(1);
        
        $this->getDoctrine()
                ->getEntityManager()
                ->flush();

        return $this->redirect($this->generateUrl('Card_list'));
    }

}
