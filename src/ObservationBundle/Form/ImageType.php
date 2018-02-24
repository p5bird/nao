<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile',   FileType::class, [
                'required'  => false,
                'label'     => "Uploader une photo",
                'attr'      => [
                    'class'     => 'custom-file-input',
                    'data-toggle' => 'modal',
                    'data-target' => '#cropp-image'
                ]
            ])
            ->add('authorization',   Type\CheckboxType::class, [
                'required'  => false,
                'label'     => "Je cède mes droits de publication et de réutilisation de la photo."
            ])
            ->add('removeMe', HiddenType::class, [
                'attr'  => [
                    'removeField' => "image",
                    'value'       => false
                ]
            ])
        ;
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