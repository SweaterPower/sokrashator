<?php

namespace App\Form;

use App\Entity\Shortcut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ShortcutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('link', TextType::class, ['label' => 'Ссылка:'])
            ->add('alias', TextType::class, [
                'required' => false,
                'constraints' => [new Length(['min' => 3])],
                'label' => 'Персональный код ссылки вместо случайного (необязательно):'])
            ->add('submit', SubmitType::class, ['label' => 'Создать!'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shortcut::class,
        ]);
    }
}
