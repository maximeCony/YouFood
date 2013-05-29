<?php
namespace YouFood\RestaurantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name');
        $builder->add('address');
    }

    public function getName()
    {
        return 'restaurant';
    }
}