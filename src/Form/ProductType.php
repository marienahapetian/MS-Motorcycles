<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductImage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('brand')
            ->add('price')
            ->add('year')
            ->add('description')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir le type',
                'required' => true,
            ])->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir la marque',
                'required' => true,
            ])->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false, // important for uploads
            ])
            ->add('save', SubmitType::class, ['label' => 'Sauvegarder'])
            ->add('cancel', ButtonType::class, ['label' => 'Annuler'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
