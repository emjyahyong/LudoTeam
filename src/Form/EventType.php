<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Game;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\DateTime;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de l\'événement',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom de l\'événement est requis.'
                    ])
                ]
            ])
            ->add('date', null, [
                'widget' => 'single_text',
                'label' => 'Date de l\'événement',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de l\'événement est requise.'
                    ]),
                    new DateTime([
                        'message' => 'La date de l\'événement n\'est pas valide.'
                    ])
                ]
            ])
            ->add('organizer', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Organisateur',
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'organisateur est requis.'
                    ])
                ]
            ])
            ->add('participants', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => true,
                'label' => 'Participants',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Les participants sont requis.'
                    ])
                ]
            ])
            ->add('games', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Jeux associés',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Au moins un jeu doit être sélectionné.'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
