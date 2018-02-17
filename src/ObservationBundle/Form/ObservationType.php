<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use ObservationBundle\Form\ImageType;

class ObservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image',         ImageType::class, [
                'required'  => false
            ])
            ->add('birdName',          Type\TextType::class, [
                'required'  => false,
                'label'     => "Nom de l'oiseau *",
                'attr'      => [
                    'class'     => 'form-control',
                    'data-autocomplete'  => 'birdName'
                ]
            ])
            ->add('noName',         Type\CheckboxType::class, [
                'required'  => false,
                'label'     => "inconnu",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('day',            Type\DateType::class, [
                'required'  => true,
                'label'     => "Date *",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('latitude',       Type\NumberType::class, [
                'required'  => true,
                'label'     => "Latitude *",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('longitude',       Type\NumberType::class, [
                'required'  => true,
                'label'     => "Longitude *",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('place',          Type\TextType::class, [
                'required'  => false,
                'label'     => "Chercher un lieu",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('comment',        Type\TextareaType::class, [
                'required'  => true,
                'label'     => "Observation *",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('valid',          Type\SubmitType::class, [
                'label'     => "Envoyer"
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Observation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'observationbundle_observation';
    }
}
