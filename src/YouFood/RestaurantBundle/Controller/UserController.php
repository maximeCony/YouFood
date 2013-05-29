<?php

namespace YouFood\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use YouFood\RestaurantBundle\Form\UserType;
use YouFood\RestaurantBundle\Entity\User;

class UserController extends Controller {

    public function createAction(Request $request) {

        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();

                $factory = $this->get('security.encoder_factory');

                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);

                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('User_list'));
            }
        }

        return $this->render('YouFoodRestaurantBundle:User:create.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

    public function listAction() {
        
        if (false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }

        $users = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:User')
                ->findAll();

        return $this->render('YouFoodRestaurantBundle:User:list.html.twig', array(
                    'users' => $users,
                ));
    }

    public function updateAction(Request $request, $idUser) {

        $user = $this->getDoctrine()
                ->getRepository('YouFoodRestaurantBundle:User')
                ->find($idUser);

        $form = $this->createForm(new UserType(), $user);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $factory = $this->get('security.encoder_factory');

                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);

                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();
                return $this->redirect($this->generateUrl('User_list'));
            }
        }

        return $this->render('YouFoodRestaurantBundle:User:update.html.twig', array(
                    'form' => $form->createView(),
                    'idUser' => $idUser,
                ));
    }

    public function removeAction($idUser) {

        $entityManager = $this->getDoctrine()->getEntityManager();
        $user = $entityManager->getRepository('YouFoodRestaurantBundle:User')
                ->find($idUser);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $idUser);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('User_list'));
    }

}
