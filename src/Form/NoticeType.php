<?php

namespace App\Form;

use App\Entity\Notice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Range;

class NoticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '20'
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 20])
                ]
            ])
            ->add('location', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '150'
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label mt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('salary', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Salaire : ',
                'label_attr' => [
                    'class' => 'form-label mt-3'
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Positive()
                ]
            ])
            ->add('schedule', NumberType:: class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Temps de travail journalier',
                'label_attr' => [
                    'class' => 'form-label mt-3'
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Range([
                        'min' => 4,
                        'max' => 13,
                        'minMessage' => 'Vous ne pouvez pas faire travailler un salarié si peu de temps',
                        'maxMessage' => 'Vous ne pouvez pas faire travailler un salarié autant de temps'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ],
                'label' => 'Valider mon annonce'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Notice::class,
        ]);
    }
}
