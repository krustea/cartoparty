<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('label'=>'Prénom', 'required'=>true))
            ->add('lastname',TextType::class, array('label'=>'Nom', 'required'=>true))
            ->add('email', EmailType::class, array('required'=>true))
            ->add('plainPassword', RepeatedType::class,[
                'type'=>PasswordType::class,
                'first_options'=> ['label'=> ' mot de passe'],
                'second_options'=> ['label'=> 'Repetez votre mot de passe']
            ])
            ->add('adress',TextType::class, array('label'=>'Adresse', 'required'=>true))
            ->add('zipcode', NumberType::class, array('label'=>'code postal', 'required'=>true))
            ->add('city',TextType::class, array('label'=>'Ville', 'required'=>true))
            ->add('phone', TelType::class, array('label'=>'n° de telephone','required'=>true))
            ->add('pictureFile', VichImageType::class, array('label'=>'Image', 'required'=> false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
