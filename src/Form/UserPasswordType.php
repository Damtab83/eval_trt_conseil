<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordType extends AbstractType
{
    /**
     * This controller allow us to change PASSWORD
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
              'type' => PasswordType::class,
              'first_options' => [
                  'label' => 'Mot de Passe',
                  'attr' => [
                      'class' => 'form-control'
                  ]
              ],
              'second_options' => [
                  'label' => 'Confirmer votre mot de passe',
                  'attr' => [
                      'class' => 'form-control'
                  ],
              ],
              'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add('newPassword', PasswordType::class, [
              'attr' => [
                'class' => 'form-control'
              ],
              'label' => 'Nouveau mot de passe',
              'mapped' => false,
              'constraints' => [
                new Assert\NotBlank([])
              ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Modifier mon mot de passe.'
              ])
              ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

