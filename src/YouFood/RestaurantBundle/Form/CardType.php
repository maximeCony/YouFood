<?php

namespace YouFood\RestaurantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CardType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name')
                ->add('current', 'checkbox', array('required' => false,))
                ->add('menus', 'entity', array('class' => 'YouFood\RestaurantBundle\Entity\Menu', 'property' => 'name', 'multiple' => true, 'required' => false,))
                ->add('plats', 'entity', array('class' => 'YouFood\RestaurantBundle\Entity\Plat', 'property' => 'name', 'multiple' => true,'required' => false,));
    }

    public function getName() {
        return 'card';
    }

}