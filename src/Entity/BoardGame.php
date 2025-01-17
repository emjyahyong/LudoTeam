<?php

namespace App\Entity;

use App\Repository\BoardGameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoardGameRepository::class)]
class BoardGame extends Game
{
    #[ORM\Column(nullable: true)]
    private ?int $boardSize = null;

    #[ORM\Column(nullable: true)]
    private ?string $boardType = null;

    // Getters et setters pour les nouvelles propriétés
    public function getBoardSize(): ?int
    {
        return $this->boardSize;
    }

    public function setBoardSize(?int $boardSize): static
    {
        $this->boardSize = $boardSize;
        return $this;
    }

    public function getBoardType(): ?string
    {
        return $this->boardType;
    }

    public function setBoardType(?string $boardType): static
    {
        $this->boardType = $boardType;
        return $this;
    }
}