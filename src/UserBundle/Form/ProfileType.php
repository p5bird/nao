<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/1/18
 * Time: 4:57 PM
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;

class ProfileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('firstname', TextType::class, array(
                'required' => false,
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prénom',
                ],
                'error_bubbling' => true
            ))
            ->add('name', TextType::class, array(
                'required' => false,
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom',
                ],
                'error_bubbling' => true
            ))
            ->add('city', TextType::class, array(
                'required' => false,
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ville',
                ],
                'error_bubbling' => true
            ))
            ->add('level', ChoiceType::class, array(
                'choices' => array(
                    'Amateur' => 'Amateur',
                    'Initié' => 'Initié',
                    'Connaisseur' => 'Connaisseur',
                    'Professionnel' => 'Professionnel',
                ),
                'required' => false,
                'label' => 'Niveau ornithologique',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Niveau ornithologique',
                ],
                'error_bubbling' => true
            ))
            ->add('birthdate', BirthdayType::class, array(
                'required' => false,
                'label' => 'Date de naissance',
                'attr' => [
                    'class' => '',
                    'placeholder' => 'Date de naissance',
                ],
                'error_bubbling' => true
        ))
            ->add('job', TextType::class, array(
                'required' => false,
                'label' => 'Profession',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Profession',
                ],
                'error_bubbling' => true
            ))
            ->add('facebook', UrlType::class, array(
                'required' => false,
                'label' => 'Facebook',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Facebook',
                ],
                'error_bubbling' => true
        ))
            ->add('pinterest', UrlType::class, array(
                'required' => false,
                'label' => 'Pinterest',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Pinterest',
                ],
                'error_bubbling' => true
            ))
            ->add('instagram', UrlType::class, array(
                'required' => false,
                'label' => 'Instagram',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Instagram',
                ],
                'error_bubbling' => true
            ))
            ->add('bio', TextAreaType::class, array(
                'required' => false,
                'label' => 'Biographie',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Biographie',
                ],
                'error_bubbling' => true
            ))
            ->add('avatar', AvatarType::class, array(
                'required' => false,
                'label' => 'Avatar',
                'attr' => [
                    'class' => 'edit-profile-avatar-input',
                    'placeholder' => 'Avatar',
                ],
                'error_bubbling' => true
            ))
            ->add('receiveNewsletter', CheckboxType::class, array(
                'required' => false,
                'label' => 'Recevoir la newsletter',
                'error_bubbling' => true
            ));
    }

    public function getParent() {
        return BaseProfileFormType::class;
    }
}