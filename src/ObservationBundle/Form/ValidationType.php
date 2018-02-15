<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use ObservationBundle\Form\ImageType;

use ObservationBundle\Form\ObservationType;

class ValidationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('birdName',          Type\TextType::class, [
                'required'  => false,
                'label'     => "Nom de l'oiseau *",
                'attr'      => [
                    'class'     => 'form-control',
                    'data-autocomplete' => 'birdName'
                ]
            ])
            ->add('noName',         Type\CheckboxType::class, [
                'required'  => false,
                'label'     => "inconnu",
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
            ->add('validationComment',        Type\TextareaType::class, [
                'required'  => true,
                'label'     => "Commentaire validateur",
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('valid',          Type\SubmitType::class, [
                'label'     => "Valider"
            ])
            ->add('reject',          Type\SubmitType::class, [
                'label'     => "Rejeter"
            ])
            ->add('cancel',          Type\SubmitType::class, [
                'label'     => "Annuler"
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
