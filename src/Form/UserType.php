<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 50
                ],
                'label' => "Prénom + Nom",
            ])
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 50
                ],
                'label' => "Pseudo (facultatif)",
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => "Mot de passe",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
