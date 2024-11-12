<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('release_date', DateTimeType::class, [
                'placeholder' => 'Enter a release date',
            ])
            ->add('director')
            ->add('genre')
            ->add('length')
            ->add('poster', FileType::class, [
                'label' => 'Poster (9/16 image)',
                'mapped' => false,
                'required' => true,
            ])
            ->add('movie', FileType::class, [
                'label' => 'Movie (video)',
                'mapped' => false,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
