<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use ObservationBundle\Form\ImageType;
use ObservationBundle\Form\DescriptionType;
use ObservationBundle\Form\ValidationType;

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
                'label'     => "Nom de l'espèce",
                'attr'      => [
                    'data-autocomplete'  => 'birdName'
                ]
            ])
            ->add('noName',         Type\CheckboxType::class, [
                'required'  => false,
                'label'     => "Je ne connais pas le nom exact de l'espèce"
            ])
            ->add('day',            Type\DateTimeType::class, [
                'required'  => true,
                'label'     => "Date de l'observation"
            ])
            ->add('latitude',       Type\TextType::class, [
                'required'  => true,
                'label'     => "Latitude"
            ])
            ->add('longitude',       Type\TextType::class, [
                'required'  => true,
                'label'     => "Longitude"
            ])
            ->add('place',          Type\TextType::class, [
                'required'  => false,
                'label'     => "Lieu de l'observation"
            ])
            ->add('comment',        Type\TextareaType::class, [
                'required'  => false,
                'label'     => "Commentaire pour le validateur"
            ])
            ->add('description',    DescriptionType::class, [
                'required'  => false,
                'label'     => "Description détaillée"
            ])
            ->add('validation',      ValidationType::class, [
                'required'  => false
            ])
            ->add('removeImage', HiddenType::class, [
                'attr'  => [
                    'removeField' => "image",
                    'value'       => false
                ]
            ])
        ;
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
