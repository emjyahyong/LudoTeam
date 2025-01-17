<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\BoardGame;
use App\Entity\CardGame;
use App\Entity\DuelGame;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTime;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        // La partie utilisateurs reste inchangée car elle fonctionne bien
        $users = $this->createUsers($manager, $faker);

        // Création des jeux avec leurs types explicites
        $games = [];
        
        // Jeux de plateau
        $boardGames = [
            ['name' => 'Échecs', 'maxPlayers' => 2],
            ['name' => 'Monopoly', 'maxPlayers' => 8],
            ['name' => 'Risk', 'maxPlayers' => 6],
            ['name' => 'Catan', 'maxPlayers' => 4],
            ['name' => 'Scrabble', 'maxPlayers' => 4]
        ];

        foreach ($boardGames as $gameData) {
            $game = new BoardGame();
            $game->setName($gameData['name'])
                 ->setMaxPlayers($gameData['maxPlayers'])
                 ->setGameType('board');  // Ajout explicite du type
            $manager->persist($game);
            $games[] = $game;
        }

        // Jeux de cartes
        $cardGames = [
            ['name' => 'Poker', 'maxPlayers' => 10],
            ['name' => 'Belote', 'maxPlayers' => 4],
            ['name' => 'Uno', 'maxPlayers' => 10],
            ['name' => '7 Wonders', 'maxPlayers' => 7]
        ];

        foreach ($cardGames as $gameData) {
            $game = new CardGame();
            $game->setName($gameData['name'])
                 ->setMaxPlayers($gameData['maxPlayers'])
                 ->setGameType('card');  // Ajout explicite du type
            $manager->persist($game);
            $games[] = $game;
        }

        // Jeux de duel
        $duelGames = [
            ['name' => 'Magic: The Gathering', 'maxPlayers' => 2],
            ['name' => 'Yu-Gi-Oh!', 'maxPlayers' => 2],
            ['name' => 'Morpion', 'maxPlayers' => 2]
        ];

        foreach ($duelGames as $gameData) {
            $game = new DuelGame();
            $game->setName($gameData['name'])
                 ->setMaxPlayers($gameData['maxPlayers'])
                 ->setGameType('duel');  // Ajout explicite du type
            $manager->persist($game);
            $games[] = $game;
        }

        // Création des événements avec une meilleure gestion des indices
        $this->createEvents($manager, $games, $users);

        $manager->flush();
    }

    private function createUsers(ObjectManager $manager, \Faker\Generator $faker): array
    {
        $users = [];
        // Création d'un admin
        $admin = new User();
        $admin->setEmail('admin@ludoteam.fr')
              ->setName('Admin')
              ->setRoles(['ROLE_ADMIN'])
              ->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);
        $users[] = $admin;

        // Création des utilisateurs réguliers
        for ($i = 0; $i < 9; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                 ->setName($faker->firstName)
                 ->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $manager->persist($user);
            $users[] = $user;
        }

        return $users;
    }

    private function createEvents(ObjectManager $manager, array $games, array $users): void
    {
        $eventTemplates = [
            [
                'name' => 'Soirée Échecs',
                'daysAhead' => 7,
                'gameIndices' => [0],  // Utilisation d'indices plutôt que d'objets directs
                'minParticipants' => 4,
                'maxParticipants' => 8
            ],
            [
                'name' => 'Tournoi de Cartes',
                'daysAhead' => 14,
                'gameIndices' => [5, 6],
                'minParticipants' => 6,
                'maxParticipants' => 12
            ],
            [
                'name' => 'Après-midi Jeux de Plateau',
                'daysAhead' => 3,
                'gameIndices' => [1, 2, 3],
                'minParticipants' => 5,
                'maxParticipants' => 10
            ],
            [
                'name' => 'Soirée Duels',
                'daysAhead' => 21,
                'gameIndices' => [9, 10],
                'minParticipants' => 4,
                'maxParticipants' => 8
            ]
        ];

        foreach ($eventTemplates as $template) {
            $event = new Event();
            $event->setName($template['name'])
                 ->setDate(new DateTime('+' . $template['daysAhead'] . ' days'))
                 ->setOrganizer($users[array_rand($users)]);

            // Ajout des jeux en utilisant les indices
            foreach ($template['gameIndices'] as $index) {
                if (isset($games[$index])) {
                    $event->addGame($games[$index]);
                }
            }

            // Ajout des participants
            $numParticipants = rand($template['minParticipants'], $template['maxParticipants']);
            $shuffledUsers = $users;
            shuffle($shuffledUsers);
            
            for ($i = 0; $i < $numParticipants && $i < count($shuffledUsers); $i++) {
                $event->addParticipant($shuffledUsers[$i]);
            }

            $manager->persist($event);
        }
    }
}