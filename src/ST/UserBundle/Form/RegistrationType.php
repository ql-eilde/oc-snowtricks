<?php

namespace ST\UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('first_name', TextType::class, array(
                'label' => "Prénom"
            ))
            ->add('last_name', TextType::class, array(
                'label' => "Nom"
            ))
            ->add('imageFile', FileType::class, array(
                'label' => "Photo de profil"
            ))
        ;
    }

    public function getParent(){
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'st_userbundle_registration';
    }

    public function getName(){
        return $this->getBlockPrefix();
    }
}