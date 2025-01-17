<?php
namespace App\Entity;

use App\Repository\CardGameRepository; 
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardGameRepository::class)]
class CardGame extends Game
{
    // Nombre de cartes dans le jeu
    #[ORM\Column(nullable: true)]
    private ?int $numberOfCards = null;

    // Type de cartes (par exemple : traditionnel, tarot, uno, etc.)
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cardType = null;

    // Indique si le jeu nécessite plusieurs paquets de cartes
    #[ORM\Column]
    private bool $multipleDecks = false;

    // Getters et setters
    public function getNumberOfCards(): ?int
    {
        return $this->numberOfCards;
    }

    public function setNumberOfCards(?int $numberOfCards): static
    {
        $this->numberOfCards = $numberOfCards;
        return $this;
    }

    public function getCardType(): ?string
    {
        return $this->cardType;
    }

    public function setCardType(?string $cardType): static
    {
        $this->cardType = $cardType;
        return $this;
    }

    public function isMultipleDecks(): bool
    {
        return $this->multipleDecks;
    }

    public function setMultipleDecks(bool $multipleDecks): static
    {
        $this->multipleDecks = $multipleDecks;
        return $this;
    }
}