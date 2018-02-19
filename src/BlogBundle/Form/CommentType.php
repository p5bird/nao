<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/16/18
 * Time: 3:58 PM
 */

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, array(
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
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
