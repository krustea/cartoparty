<?php

namespace App\Form;

use App\Entity\Travel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Travel1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', TextType::class, array('label'=>'Ville', 'required'=>true))
            ->add('started_at', DateTimeType::class, array('label'=>'depart le:', 'required'=>true))
            ->add('nb_user', TextType::class, array('label'=>'Nombre de voyageurs','required'=>true))
            ->add('price', MoneyType::class, array('label'=>'Tarif ', 'required'=>true))
            ->add('party',null, array('label'=>'Evenement',  'required'=> true) )
//            ->add('user')
            ->add('category',null, array('label'=>'Trajet'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Travel::class,
        ]);
    }
}
