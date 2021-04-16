<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckBoxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false
            ])
            ->add('category')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => false,
            ])
            ->add('price')
            ->add('address')
            ->add('description')
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Location' => 'Location',
                    'Vente' => 'Vente'
                ],
            ])
            ->add('promo')
            ->add('published', CheckBoxType::class, [
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Terminé' => 'Terminé',
                    'Vendu' => 'Vendu',
                    'Disponible' => 'Disponible'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
