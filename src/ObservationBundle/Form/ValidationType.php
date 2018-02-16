<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class ValidationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('comment',        Type\TextareaType::class, [
            //     'required'  => true,
            //     'label'     => "Commentaire de validation",
            //     'attr'      => [
            //         'class'     => 'form-control'
            //     ]
            // ])
            ->add('valid',          Type\SubmitType::class, [
                'label'     => "Valider"
            ])
            ->add('reject',          Type\SubmitType::class, [
                'label'     => "Rejeter"
            ])
            ->add('cancel',          Type\SubmitType::class, [
                'label'     => "Laisser en attente"
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Validation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'observationbundle_validation';
    }
}
