<?php
namespace App\Entity;

use App\Repository\DuelGameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DuelGameRepository::class)]
class DuelGame extends Game
{
    // Durée moyenne d'un duel en minutes
    #[ORM\Column(nullable: true)]
    private ?int $averageDuration = null;

    // Mode de victoire (par exemple : KO, points, soumission)
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $victoryCondition = null;

    // Indique si des équipements spéciaux sont nécessaires
    #[ORM\Column]
    private bool $requiresEquipment = false;

    // Liste des équipements requis si nécessaire
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $requiredEquipment = null;

    // Niveau de contact physique (aucun, léger, modéré, intense)
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $contactLevel = null;

    // Getters et setters
    public function getAverageDuration(): ?int
    {
        return $this->averageDuration;
    }

    public function setAverageDuration(?int $averageDuration): static
    {
        $this->averageDuration = $averageDuration;
        return $this;
    }

    public function getVictoryCondition(): ?string
    {
        return $this->victoryCondition;
    }

    public function setVictoryCondition(?string $victoryCondition): static
    {
        $this->victoryCondition = $victoryCondition;
        return $this;
    }

    public function getRequiresEquipment(): bool
    {
        return $this->requiresEquipment;
    }

    public function setRequiresEquipment(bool $requiresEquipment): static
    {
        $this->requiresEquipment = $requiresEquipment;
        return $this;
    }

    public function getRequiredEquipment(): ?string
    {
        return $this->requiredEquipment;
    }

    public function setRequiredEquipment(?string $requiredEquipment): static
    {
        $this->requiredEquipment = $requiredEquipment;
        return $this;
    }

    public function getContactLevel(): ?string
    {
        return $this->contactLevel;
    }

    public function setContactLevel(?string $contactLevel): static
    {
        $this->contactLevel = $contactLevel;
        return $this;
    }
}