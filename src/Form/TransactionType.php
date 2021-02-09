<?php

namespace App\Form;

use App\Repository\TransactionRepository;
use App\Entity\Transaction;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', TextType::class, [
                'empty_data' => "9087"
            ])
            ->add('dateTransaction', DateType::class, [
                'widget' => 'choice',
                'label' => 'Date',
                'view_timezone' => 'Europe/Paris',
                'model_timezone' => 'Europe/Paris',
                'format' => 'dd MMMM yyyy',
                'years' => range(2021, 2022),
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ]
            ])
            ->add('description', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Sélectionner' => '',
                    'À diviser' => '1',
                    'À rembourser' => '2',
                    'Personnel' => '3'
                ],
            ])
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Sélectionner' => '',
                    'Loyer' => '1',
                    'Courses' => '2',
                    'Achat & Shopping' => '3',
                    'Restauration' => '4',
                    'Transport' => '5',
                    'Abonnement' => '6',
                    'Autres' => '7'
                ],
            ])
            ->add('username', ChoiceType::class, [
                'choices' => [
                    'Sélectionner' => '',
                    'Mathis' => 'Mathis',
                    'Abigail' => 'Abigail',
                ],
            ])
            ->add('statut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
