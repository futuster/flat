<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')

            ->add(
                'password',
                PasswordType::class,
                [
                    'constraints' => [
                        new Length(
                            [
                                'min' => 5,
                                'max' => 128,
                            ]
                        ),
                    ],
                    'label' => 'Придумайте пароль',
                    'attr' => ['autocomplete' => 'password'],
//                    'mapped' => false,
                    'required' => false,
                    'empty_data' => '',
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
