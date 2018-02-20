<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class SearchType extends AbstractType
{

    public function __construct($entityManager)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('birdName',          Type\TextType::class, [
                'required'  => false,
                'label'     => "Nom de l'oiseau",
                'attr'      => [
                    'class'     => 'form-control',
                    'data-autocomplete'  => 'birdName'
                ]
            ])
            ->add('family', ChoiceType::class, [
                'label'     => "Famille d'oiseaux"
                'choices'   => [
                    'Maybe' => null,
                    'Yes'   => true,
                    'No'    => false
                ]
            ]),
            ->add('order', ChoiceType::class, [
                'label'     => "Ordre d'oiseaux"
                'choices'   => [
                    'Maybe' => null,
                    'Yes'   => true,
                    'No'    => false
                ]
            ]),
            ->add('day',            Type\DateType::class, [
                'required'  => true,
                'label'     => "Date de l'observation",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('author',          Type\TextType::class, [
                'required'  => false,
                'label'     => "Pseudo de l'observateur",
                'attr'      => [
                    'class'     => 'form-control',
                    'data-autocomplete'  => 'birdName'
                ]
            ])
            ->add('place',          Type\TextType::class, [
                'required'  => false,
                'label'     => "Chercher un lieu",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('image',         Type\CheckboxType::class, [
                'required'  => false,
                'label'     => "Observations avec une photo uniquement",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('valid',          Type\SubmitType::class, [
                'label'     => "Chercher"
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
