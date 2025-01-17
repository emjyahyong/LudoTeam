<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventApiController extends AbstractController
{
    #[Route('/api/events', name: 'api_events', methods: ['GET'])]
    public function getEvents(EventRepository $eventRepository): JsonResponse
    {
        // Récupérer tous les événements avec les participants et les jeux associés
        $events = $eventRepository->findAll();

        // Transformer les événements en JSON
        $data = [];

        foreach ($events as $event) {
            $participants = [];
            foreach ($event->getParticipants() as $participant) {
                $participants[] = [
                    'id' => $participant->getId(),
                    'name' => $participant->getName(),
                    'email' => $participant->getEmail(),
                ];
            }

            $games = [];
            foreach ($event->getGames() as $game) {
                $games[] = [
                    'id' => $game->getId(),
                    'name' => $game->getName(),
                    'type' => $game->getGameType(),
                ];
            }

            $data[] = [
                'id' => $event->getId(),
                'name' => $event->getName(),
                'date' => $event->getDate()->format('Y-m-d H:i:s'),
                'organizer' => [
                    'id' => $event->getOrganizer()->getId(),
                    'name' => $event->getOrganizer()->getName(),
                    'email' => $event->getOrganizer()->getEmail(),
                ],
                'participants' => $participants,
                'games' => $games,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/events/{id}', name: 'api_event', methods: ['GET'])]
    public function getEventById(Event $event): JsonResponse
    {
        $data = [
            'id' => $event->getId(),
            'name' => $event->getName(),
            'date' => $event->getDate()->format('Y-m-d H:i:s'),
            'organizer' => [
                'id' => $event->getOrganizer()->getId(),
                'name' => $event->getOrganizer()->getName(),
                'email' => $event->getOrganizer()->getEmail(),
            ],
            'participants' => array_map(function ($participant) {
                return [
                    'id' => $participant->getId(),
                    'name' => $participant->getName(),
                    'email' => $participant->getEmail(),
                ];
            }, $event->getParticipants()->toArray()),
            'games' => array_map(function ($game) {
                return [
                    'id' => $game->getId(),
                    'name' => $game->getName(),
                    'type' => $game->getGameType(),
                ];
            }, $event->getGames()->toArray())
        ];

        return new JsonResponse($data);
    }
}
