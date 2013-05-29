<?php

namespace YouFood\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller {

    public function loginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('YouFoodRestaurantBundle:Security:login.html.twig', array(
                    // last username entered by the user
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
                ));
    }

    public function redirectAction() {

        if (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('Restaurant_list'));
        }

        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            
            $user = $this->get('security.context')->getToken()->getUser();
            $restaurant = $user->getRestaurant();
            
            return $this->redirect($this->generateUrl('Restaurant_manage', array('idRestaurant' => $restaurant->getId())));
        }
        return $this->redirect($this->generateUrl('YouFoodRestaurantBundle_homepage'));
    }

}