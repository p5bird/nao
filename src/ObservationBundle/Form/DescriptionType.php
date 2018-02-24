<?php

namespace ObservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class DescriptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('environment',    TextType::class, [
                'required'  => false,
                'label'     => "Milieu de l'observation",
                'attr'      => [
                    'placeholder'   => "fôret, prairie, culture, plan d'eau, etc..."
                ]    
            ])
            ->add('size',    ChoiceType::class, [
                'required'  => false,
                'label'     => "Taille de l'oiseau",
                'choices'   => [
                    "Petit | L ~15cm"             => "Petit",
                    "Très petit | L < 15cm"        => "Très petit",
                    "Moyen inférieur | L ~25cm"   => "Moyen inférieur",
                    "Moyen | L ~35cm, E ~50cm"             => "Moyen",
                    "Moyen supérieur | L ~45cm, E ~100cm"   => "Moyen supérieur",
                    "Grand | ~55cm, E ~120cm"             => "Grand",
                    "Très grand | L > 100cm, E > 150cm"        => "Très grand"
                ]
            ])
            ->add('wings',    TextType::class, [
                'required'  => false,
                'label'     => "Morphologie des ailes",
                'attr'      => [
                    'placeholder' => "longues, étroites, pointues, courtes, larges, arrondies..."
                ]    
            ])
            ->add('tail',    TextType::class, [
                'required'  => false,
                'label'     => "Morphologie de la queue",
                'attr'      => [
                    'placeholder' => "courte, moyenne, longue, carrée, arrondie, fourchue..."
                ]    
            ])
            ->add('paws',    TextType::class, [
                'required'  => false,
                'label'     => "Morphologie des pattes",
                'attr'      => [
                    'placeholder' => "courtes, moyennes, longues, très longues, dépassent de la queue en vol..."
                ]    
            ])
            ->add('beak',    TextType::class, [
                'required'  => false,
                'label'     => "Morphologie du bec",
                'attr'      => [
                    'placeholder' => "forme, fin, long, court, épais, plat, haut, conique, courbe, crochu..."
                ]    
            ])
            ->add('plumageColor',    TextType::class, [
                'required'  => false,
                'label'     => "Couleur(s) du plumage"    
            ])
            ->add('bareColor',    TextType::class, [
                'required'  => false,
                'label'     => "Couleur(s) des parties nues"
            ])
            ->add('pawsColor',    TextType::class, [
                'required'  => false,
                'label'     => "Couleur(s) des pattes"    
            ])
            ->add('beakColor',    TextType::class, [
                'required'  => false,
                'label'     => "Couleur(s) du bec"    
            ])
            // ->add('escape',    TextareaType::class, [
            //     'required'  => false,
            //     'label'     => "Comportement en fuite",
            //     'attr'      => [
            //         'placeholder' => "le fait-il de loin ou dans les pieds ? \n
            //             S'esquive-t-il au sol ou alors s'envole-t-il ? Dans le premier cas, court il sur ses pattes en alternance ou saute-t-il sur ses deux pattes à la fois ? \n
            //             S'il s'envole, comment est le vol ? \n
            //             Les battements d'ailes sont-ils réguliers et constants ou bien les ailes ne battent-elles que de façon périodique, le vol devenant de ce fait onduleux ?"
            //     ]    
            // ])
            // ->add('move',    TextareaType::class, [
            //     'required'  => false,
            //     'label'     => "Comportement en mouvement",
            //     'attr'      => [
            //         'placeholder' => "En milieu terrestre, se déplace-t-il spontanément au sol ou n'y va-t-il que ponctuellement ou pas du tout ? Ou bien se déplace-t-il dans la végétation ? Plutôt dans les hautes herbes ou plutôt dans les ligneux (buissons et arbres) ? Dans les arbres, explore-t-il la canopée ou se déplace-t-il le long des troncs ou des branches ? \n
            //             En milieu aquatique, marche-t-il en eau peu profonde ou nage-t-il ? Reste-t-il en surface ou plonge-t-il aussi ? \n
            //             En milieu aérien, le vol est-il battu ou plané, ou encore les deux en alternance ?"
            //     ]    
            // ])
            // ->add('land',    TextareaType::class, [
            //     'required'  => false,
            //     'label'     => "Comportement au posé",
            //     'attr'      => [
            //         'placeholder' => "se met-t-il en évidence sur un perchoir ou reste-t-il à couvert ? \n
            //             Se tient-il normalement, c'est à dire le corps oblique, ou alors le corps plutôt horizontal ou au contraire très vertical ? \n
            //             Montre-t-il des mouvements nerveux des ailes et/ou de la queue ?"
            //     ]    
            // ])
            // ->add('sounds',    TextType::class, [
            //     'required'  => false,
            //     'label'     => "Vocalises de l'oiseau",
            //     'attr'      => [
            //         'placeholder' => "sifflement sourd avec variations durant 34 secondes, caché dans la végétation"
            //     ]    
            // ])
            ->add('number',    IntegerType::class, [
                'required'  => false,
                'label'     => "Nombre d'oiseaux observés",
                'attr'      => [
                    'min'   => '1'
                ]
            ])
            ->add('nest',    CheckboxType::class, [
                'required'  => false,
                'label'     => "Présence d'un nid"   
            ])
            ->add('eggs',    IntegerType::class, [
                'required'  => false,
                'label'     => "Nombre d'oeufs dans le nid",
                'attr'      => [
                    'min'   => '0'
                ]   
            ])
            ->add('comment',    TextareaType::class, [
                'required'  => true,
                'label'     => "Description détaillée",
                'attr'      => [
                    'placeholder' => "Donnez un maximum de détails, conditions de l'observation, compléments sur le milieu, la morphologie, le comportement, le nombre d'individus et leurs intéractions entre eux, les couleurs de l'oiseau..."
                ]    
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Description'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'observationbundle_description';
    }


}
