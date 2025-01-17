<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['event:read', 'user:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'eventsOrganized')]
    #[Groups(['event:read', 'user:read'])]
    private ?User $organizer = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'eventsParticipating')]
    #[Groups(['event:read', 'user:read'])]
    private Collection $participants;

    #[ORM\Column(length: 255)]
    #[Groups(['event:read', 'user:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['event:read', 'user:read'])]
    private ?\DateTimeInterface $date = null;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\ManyToMany(targetEntity: Game::class, inversedBy: 'events')]
    #[Groups(['event:read', 'user:read'])]
    private Collection $games;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrganizer(): ?User
    {
        return $this->organizer;
    }

    public function setOrganizer(?User $organizer): static
    {
        $this->organizer = $organizer;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->addEventsParticipating($this);
        }

        return $this;
    }

    public function removeParticipant(User $participant): static
    {
        if ($this->participants->removeElement($participant)) {
            $participant->removeEventsParticipating($this);
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        $this->games->removeElement($game);

        return $this;
    }
}
