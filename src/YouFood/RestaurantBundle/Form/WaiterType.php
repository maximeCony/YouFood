<?php 
namespace YouFood\RestaurantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class WaiterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name');
    }

    public function getName()
    {
        return 'waiter';
    }
}