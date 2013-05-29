<?php

namespace YouFood\RestaurantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder->add('username')
                ->add('email','email')
                ->add('password', 'password')
                ->add('groups', 'entity', array(
                    'class' => 'YouFood\RestaurantBundle\Entity\Group',
                    'property' => 'name',
                    'multiple' => true,
                    'required' => true,
                    'empty_value' => 'Choose some roles',
                ))
                ->add('restaurant', 'entity', array(
                    'class' => 'YouFood\RestaurantBundle\Entity\Restaurant',
                    'property' => 'name',
                    'required' => false,
                    'empty_value' => 'From the restaurant',
                ));
    }

    public function getName() {
        return 'user';
    }

}