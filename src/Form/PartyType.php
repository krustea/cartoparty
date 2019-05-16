<?php

namespace App\Form;

use App\Entity\Party;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PartyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label'=>'Nom : ',  'required'=> true))
            ->add('pictureFile', VichImageType::class, array('label'=>'Image', 'required'=> true))
            ->add('city', TextType::class, array('label'=>'Ville',  'required'=> true))
            ->add('started_at', DateTimeType::class, array('label'=>'Débute le :'))
            ->add('ended_at',DateTimeType::class, array('label'=>'Termine le :'))
            ->add('description', TextareaType::class, array('label'=>'Description'))
//            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Party::class,
        ]);
    }
}
