<?php

namespace App\Form;

use App\Entity\Art;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class ArtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', textType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Titre du projet ou produit'],
            ])
            ->add('description', textareaType::class, [
                'label' => 'Description',
                'attr' => ['placeholder' => 'Description du projet ou produit'],
            ])
            ->add('type', ChoiceType::class,[
                'label' => 'Type',
                'choices'=>[
                'Projet' => 'Projet',
                'Produit' => 'Produit',
            ],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
                'required' => false,
                'attr' => ['placeholder' => 'Prix du produit'],
            ])
            ->add('mainImages', FileType::class, [
                'label' => 'Ajouter photos',
                'mapped' => false,
                'multiple' => true,
                'required' => false,
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '10M',
                            'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                            'maxSizeMessage' => 'L\'image est trop lourde ({{ size }} {{ suffix }}). Le maximum autorisé est {{ limit }} {{ suffix }}.',
                        ])
                    ])
                ]

            ])
            ->add('transiImages', FileType::class, [
                'label' => 'Ajouter photos de transi',
                'mapped' => false,
                'multiple' => true,
                'required' => false,
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '10M',
                            'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                            'maxSizeMessage' => 'L\'image est trop lourde ({{ size }} {{ suffix }}). Le maximum autorisé est {{ limit }} {{ suffix }}.',
                        ])
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Art::class,
        ]);
    }
}
