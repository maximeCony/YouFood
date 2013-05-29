<?php
namespace YouFood\RestaurantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name')
                ->add('description', 'textarea')
                ->add('price');
    }

    public function getName()
    {
        return 'plat';
    }
}