<?php

namespace YouFood\RestaurantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ZoneType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name')
                ->add('waiter', 'entity', array(
                    'class' => 'YouFood\RestaurantBundle\Entity\Waiter',
                    'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                        return $er->createQueryBuilder('w')
                                ->leftJoin('w.zone', 'z')
                                ->where('z.id is null');
                    },
                    'property' => 'name',
                    'multiple' => false,
                    'required' => true,
                    'empty_value' => 'Choose a waiter',
                ))
        /* ->add('waiter', new WaiterType()) */;
    }

    public function getName() {
        return 'zone';
    }

}