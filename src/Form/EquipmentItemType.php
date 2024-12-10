<?php
// src/Form/EquipmentItemType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\EquipmentItem;
use App\Entity\EquipmentType;
use App\Entity\Location;
use App\Enum\EquipmentState;

class EquipmentItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('state', ChoiceType::class, [
                'choices' => [
                    'Neuf' => EquipmentState::NEUF,
                    'Bon état' => EquipmentState::BON_ETAT,
                    'Usé' => EquipmentState::USE,
                    'En réparation' => EquipmentState::EN_REPARATION,
                    'Hors service' => EquipmentState::HORS_SERVICE,
                    'En location' => EquipmentState::EN_LOCATION,
                ],
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500',
                ],
                'row_attr' => [
                    'class' => 'mb-4 sm:mb-5',
                ],
                'label' => 'État',
                'label_attr' => [
                    'class' => 'dark:text-white',
                ],
            ])
            ->add('equipmentType', EntityType::class, [
                'class' => EquipmentType::class,
                'choice_label' => function (EquipmentType $equipmentType) {
                    return $equipmentType->getName() . ' - ' . $equipmentType->getBrand();
                },
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500',
                ],
                'row_attr' => [
                    'class' => 'mb-4 sm:mb-5',
                ],
                'label' => 'Type d\'Équipement',
                'label_attr' => [
                    'class' => 'dark:text-white',
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'id',
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500',
                ],
                'row_attr' => [
                    'class' => 'mb-4 sm:mb-5',
                ],
                'label' => 'Emplacement',
                'label_attr' => [
                    'class' => 'dark:text-white',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EquipmentItem::class,
        ]);
    }
}