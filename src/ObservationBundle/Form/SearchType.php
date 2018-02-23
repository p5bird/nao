<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class SearchType extends AbstractType
{
    private $searchService;

    public function __construct($searchFilteredService)
    {
        $this->searchService = $searchFilteredService;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('birdName',          Type\TextType::class, [
                'required'  => false,
                'label'     => "Nom de l'espèce",
                'attr'      => [
                    'data-autocomplete'  => 'birdName'
                ]
            ])
            ->add('birdFamily', Type\ChoiceType::class, [
                'label'     => "Famille d'oiseaux",
                'choices'   => $this->searchService->getBirdFamiliesChoices()
            ])
            ->add('birdOrder',  Type\ChoiceType::class, [
                'label'     => "Ordre d'oiseaux",
                'choices'   => $this->searchService->getBirdOrdersChoices()
            ])
            ->add('birdSize',   Type\ChoiceType::class, [
                'label'     => "Taille de l'oiseau",
                'choices'   => ['xs', 'xxs', 's', 'm', 'l', 'xl', 'xxl']
            ])
            ->add('birdColor',  Type\TextType::class, [
                'required'  => false,
                'label'     => "Couleur(s) de l'oiseau"
            ])
            ->add('obsAuthor',  Type\TextType::class, [
                'required'  => false,
                'label'     => "Pseudo de l'observateur"
            ])
            // ->add('ObsDate',            Type\DateType::class, [
            //     'required'  => true,
            //     'label'     => "Date de l'observation"
            // ])
            ->add('obsLocation', Type\TextType::class, [
                'required'  => false,
                'label'     => "Lieu de l'observation"
            ])
            ->add('obsWithImage', Type\CheckboxType::class, [
                'required'  => false,
                'label'     => 'Observation avec photo uniquement'
            ])
            ->add('search',      Type\SubmitType::class, [
                'label'     => "Rechercher"
            ])
            ->add('reset',       Type\ResetType::class, [
                'attr'      => ['class' => 'reset']
            ])
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Search'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'observationbundle_search';
    }
}
