<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Titre ou résumé pour votre commentaire (requis)",
                    'autocomplete' => 'off',
                ],
            ])
            ->add('content', TextAreaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Entrez ici votre commentaire",
                    'style' => "height:80px;background-color:#fff;resize:none;",
                    'autocomplete' => 'off',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Commenter',
                'attr' => [
                    'class' => 'btn btn-dark',
                ]
            ])
        ;
    }
}