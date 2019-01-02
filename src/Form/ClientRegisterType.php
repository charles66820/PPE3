<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, [
                'label' => 'Votre identifiant',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Identifiant"
                ],
            ])
            ->add('email', RepeatedType::class, [
                'required' => true,
                'invalid_message' => 'L\'email et l\'email de confirmation doivent être identique.',
                'type' => EmailType::class,
                'first_options'  => [
                    'label' => 'Votre email',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Votre email"
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmez votre email',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Confirmez votre email"
                    ],
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'required' => true,
                'invalid_message' => 'Le mots de passe et le mots de passe de confirmation doivent être identique.',
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Votre mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Votre mot de passe"
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Confirmez votre mot de passe"
                    ],
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Votre nom"
                ],
                'required' => false,
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Votre prénom"
                ],
                'required' => false,
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Votre n° de téléphone',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Votre n° de téléphone"
                ],
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => "Je m'inscris",
                'attr'=> [
                    'class'=> 'btn btn-primary',
                ]
            ])
        ;
    }
}