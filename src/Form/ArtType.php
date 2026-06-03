<?php

namespace App\Form;

use App\Entity\Art;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', textType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Titre du projet ou produit'],
            ])
            ->add('Description', textareaType::class, [
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
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
                'required' => false,
                'attr' => ['placeholder' => 'Prix du produit'],
            ])
            ->add('mainImage', FileType::class, [
                'label' => 'Ajouter photos',
                'mapped' => false,
                'multiple' => true,
                'required' => false,
            ])
            ->add('transiImages', FileType::class, [
                'label' => 'Ajouter photos de transi',
                'mapped' => false,
                'multiple' => true,
                'required' => false,
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
