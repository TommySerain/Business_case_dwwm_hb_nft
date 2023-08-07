<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')

            ->add('password')
            ->add('firstname')
            ->add('lastname')
            ->add('pseudo')
            ->add('gender')
            ->add('birthdate')
            ->add('address')
            ->add('zipcode')
            ->add('country', EntityType::class, [
                'class' => 'App\Entity\Country',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
