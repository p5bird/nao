<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;

class ObservationCheckType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('image')
            ->remove('noName')
            ->remove('day')
            ->remove('latitude')
            ->remove('longitude')
            ->remove('place')
            ->remove('comment')
            ->remove('description')
            ->remove('save')
            ->remove('valid')
            ->add('valid',          Type\SubmitType::class, [
                'label'     => "Valider",
                'attr'      => [
                    'class'  => 'btn-nao'
                ]
            ])
            ->add('reject',          Type\SubmitType::class, [
                'label'     => "Rejeter",
                'attr'      => [
                    'class'  => 'btn-danger'
                ]
            ])
            ->add('cancel',          Type\SubmitType::class, [
                'label'     => "Retour",
                'attr'      => [
                    'class'  => 'btn-default'
                ]
            ])
        ;
    }

    public function getParent()
    {
        return ObservationType::class;
    }
}
