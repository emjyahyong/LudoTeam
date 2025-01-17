<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\Collection;
use PHPUnit\TextUI\XmlConfiguration\Groups;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "board" => BoardGame::class,
    "card" => CardGame::class,
    "duel" => DuelGame::class
])]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['event:read', 'user:read'])]
    private ?int $id = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'games')]
    #[Groups(['event:read', 'user:read'])]
    private Collection $events;

    #[ORM\Column(length: 255)]
    #[Groups(['event:read', 'user:read'])]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $maxPlayers = null;

    #[ORM\Column(length: 255)]
    #[Groups(['event:read', 'user:read'])]
    private ?string $gameType = null;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->addGame($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            $event->removeGame($this);
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMaxPlayers(): ?int
    {
        return $this->maxPlayers;
    }

    public function setMaxPlayers(int $maxPlayers): static
    {
        $this->maxPlayers = $maxPlayers;

        return $this;
    }

    public function getGameType(): ?string
    {
        return $this->gameType;
    }

    public function setGameType(string $gameType): static
    {
        $this->gameType = $gameType;

        return $this;
    }
}
