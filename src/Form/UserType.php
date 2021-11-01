<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')

            ->add(
                'password',
                PasswordType::class,
//                [
//                    'help' => 'Оставьте пустым, чтобы не изменять пароль',
//                    'constraints' => [
//                        new Length(
//                            [
//                                'min' => 5,
//                                'max' => 128,
//                            ]
//                        ),
//                    ],
//                    'mapped' => false,
//                    'label' => 'Новый пароль',
//                    'required' => false,
//                    'attr' => ['autocomplete' => 'password'],
//                    'empty_data' => 'JohnDoe',
//                ]
            )

            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => array_combine(User::AVAILABLE_ROLES,User::AVAILABLE_ROLES),
                    'expanded' => true,
                    'multiple' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => User::class,
                               ]);
    }
}
