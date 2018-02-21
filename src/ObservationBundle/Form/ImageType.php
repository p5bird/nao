<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type;

class ImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile',   FileType::class, [
                'label'     => "Uploader une photo",
                'attr'      => [
                    'class'     => 'custom-file-input',
                    'data-toggle' => 'modal',
                    'data-target' => '#cropp-image'
                ]
            ])
            ->add('authorization',   Type\CheckboxType::class, [
                'required'  => true,
                'label'     => "Je cèdes mes droits de publication et de réutilisation de la photo."
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Image'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'observationbundle_image';
    }


}