<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom du jeu',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom du jeu est requis.'
                    ])
                ]
            ])
            ->add('maxPlayers', null, [
                'label' => 'Nombre maximum de joueurs',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nombre de joueurs est requis.'
                    ])
                ]
            ])
            ->add('gameType', null, [
                'label' => 'Type de jeu',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le type de jeu est requis.'
                    ])
                ]
            ])
            ->add('events', EntityType::class, [
                'class' => Event::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Événements associés',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Au moins un événement doit être sélectionné.'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
