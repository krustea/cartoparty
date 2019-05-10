<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Travel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Booking1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,  array $options)
    {
        $builder
//            ->add('valid')
            ->add('nbTravelers', IntegerType::class, [
                "attr" => ["min" => 1, "max"=> $options["max"]]
            ])
//            ->add('user')
//            ->add('travel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'max' => 1
        ]);
    }
}
