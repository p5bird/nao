<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;

class ObservationAddType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('validation')
            ->add('valid',          Type\SubmitType::class, [
                'label'     => "Demander la publication",
                'attr'      => [
                    'class'  => 'btn-nao'
                ]
            ])
            ->add('save',          Type\SubmitType::class, [
                'label'     => "Sauvegarder"
            ])
        ;
    }

    public function getParent()
    {
        return ObservationType::class;
    }
}
