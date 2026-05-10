<?php

namespace App\Form;

use App\Entity\WebsiteSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('instagram_link')
            ->add('tweeter_link')
            ->add('tiktok_link')
            ->add('font', ChoiceType::class, [
                'choices' => [
                    'Arial' => 'Arial, sans-serif',
                    'Roboto' => "'Roboto', sans-serif",
                    'Open Sans' => "'Open Sans', sans-serif",
                    'Montserrat' => "'Montserrat', sans-serif",
                    'Bricolage Grotesque' => "'Bricolage Grotesque', sans-serif"
                ],
            ])
            ->add('accent_color', ColorType::class)
            ->add('black_color', ColorType::class)
            ->add('white_color', ColorType::class)
            ->add('location', TextareaType::class)
            ->add('address')
            ->add('phone')
            ->add('email')
            ->add('save', SubmitType::class, ["label" => "Sauvegarder"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WebsiteSettings::class,
        ]);
    }
}
