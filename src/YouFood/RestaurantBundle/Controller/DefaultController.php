<?php

namespace YouFood\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {

        return $this->render('YouFoodRestaurantBundle:Default:index.html.twig');
    }


}
