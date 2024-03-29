<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class)
            ->add('name',TextType::class)
            ->add('password', RepeatedType::class, array(
                'type'=>PasswordType::class,
                'first_options'=>array('label'=>'Password'),
                'second_options'=>array('label'=>'Repeat password')
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }


}
