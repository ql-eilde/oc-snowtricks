<?php

namespace ST\UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('first_name', TextType::class)
            ->add('last_name', TextType::class)
            ->add('imageFile', FileType::class);
    }

    public function getParent(){
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'st_userbundle_profile';
    }

    public function getName(){
        return $this->getBlockPrefix();
    }
}