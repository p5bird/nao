<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class ObservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('noName',         Type\CheckboxType::class, [
                'required'  => false,
                'label'     => "inconnu",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('day',            Type\DateType::class, [
                'label'     => "Date",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('gpsCoord',       Type\TextType::class, [
                'label'     => "Coordonnées GPS",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('place',          Type\TextType::class, [
                'required'  => false,
                'label'     => "Lieu",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('town',           Type\TextType::class, [
                'required'  => false,
                'label'     => "Ville",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('county',         Type\TextType::class, [
                'required'  => false,
                'label'     => "Département",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('region',         Type\TextType::class, [
                'required'  => false,
                'label'     => "Région",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('comment',        Type\TextareaType::class, [
                'required'  => false,
                'label'     => "Commentaire",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('taxon',          Type\TextType::class, [
                'required'  => false,
                'label'     => "taxon!!",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('valid',          Type\SubmitType::class, [
                'label'     => "Envoyer"
            ]);
    }/**
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
