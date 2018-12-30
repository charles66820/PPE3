<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('way', TextType::class, [
                'required' => true,
                'label' => 'Adresse',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Adresse"
                ],
            ])
            ->add('complement', TextType::class, [
                'label' => 'Complément d\'adresse',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Complément d\'adresse"
                ],
            ])
            ->add('zipCode', TextType::class, [
                'required' => true,
                'label' => 'Code postal',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Code postal"
                ],
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Ville"
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter l\'adresse',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])
        ;
    }
}