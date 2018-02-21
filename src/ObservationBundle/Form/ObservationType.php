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
                'label'     => "Nom de l'oiseau",
                'attr'      => [
                    'data-autocomplete'  => 'birdName'
                ]
            ])
            ->add('noName',         Type\CheckboxType::class, [
                'required'  => false,
                'label'     => "je ne connais pas le nom exact"
            ])
            ->add('day',            Type\DateType::class, [
                'required'  => true,
                'label'     => "Date de l'observation"
            ])
            ->add('latitude',       Type\NumberType::class, [
                'required'  => true,
                'label'     => "Latitude"
            ])
            ->add('longitude',       Type\NumberType::class, [
                'required'  => true,
                'label'     => "Longitude"
            ])
            ->add('place',          Type\TextType::class, [
                'required'  => false,
                'label'     => "Chercher un lieu sur la carte"
            ])
            ->add('comment',        Type\TextareaType::class, [
                'required'  => true,
                'label'     => "Description de l'observation"
            ])
            ->add('valid',          Type\SubmitType::class, [
                'label'     => "Demander la publication",
                'attr'      => [
                    'class'  => 'btn-nao'
                ]
            ])
            ->add('save',          Type\SubmitType::class, [
                'label'     => "Sauvegarder"
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
