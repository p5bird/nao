<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/12/18
 * Time: 5:16 PM
 */

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                'label' => false,
                'attr' => [
                    'class' => 'custom-file-input',
                    'data-toggle' => 'modal',
                    'data-target' => '#cropp-avatar'
                ],
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Image'
        ));
    }
}
