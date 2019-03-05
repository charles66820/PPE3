<?php
namespace App\Form;

use App\Entity\Address;
use App\Entity\Client;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ClientType extends AbstractType
{
    protected $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $builder
            ->add('login', TextType::class, [
                'required' => true,
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
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Votre mot de passe actuel',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Votre mot de passe actuel"
                ],
                'required' => true,
            ])
            ->add('newPassword', RepeatedType::class, [
                'required' => false,
                'invalid_message' => 'Le mots de passe et le mots de passe de confirmation doivent être identique.',
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Votre nouveau mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Votre nouveau mot de passe"
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmez votre nouveau mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Confirmez votre nouveau mot de passe"
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
                'label' => 'Sauvegarder',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'style' => 'margin-right:8px;',
                ]
            ])
            ->add('reset', ResetType::class, [
                'label' => 'Annuler',
                'attr' => [
                    'class' => 'btn btn-danger',
                ]
            ])
            ->add('defaultAddress', EntityType::class, [
                'label' => 'Adresse par défaut :',
                'required' => false,
                'class' => Address::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('a')
                        ->where('a.client = :idcli')
                        ->setParameter('idcli', $user->getId());
                },
                'choice_label' => 'address',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('avatarFile', FileType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'client_avatarFile',//à modifier aussi dans profile.js
                ],
                'data_class' => null,
            ])
        ;
    }
}