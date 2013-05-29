<?php 
namespace YouFood\RestaurantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name');
    }

    public function getName()
    {
        return 'tone';
    }
}