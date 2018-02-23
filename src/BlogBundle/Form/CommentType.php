<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/16/18
 * Time: 3:58 PM
 */

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, array(
                'label' => 'Nouveau commentaire',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Rédigez un nouveau commentaire...'
                ],
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Comment'
        ));
    }
}
