<?php
namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductPicture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pictureName', FileType::class, [
                'required' => true,
                'data_class' => null,
                'attr' => [
                    'style' => 'opacity:1;',
                ]
            ])
            ->add('product', EntityType::class, [
                'required' => true,
                'class' => Product::class,
                'choice_label' => 'title',
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProductPicture::class,
        ));
    }
}