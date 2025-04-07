<?php
// src/Entity/CarryOverConge.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CarryOverConge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\ManyToOne(targetEntity: "App\Entity\User")]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type:"string", length:50)]
    private $typeConge;

    #[ORM\Column(type:"integer")]
    private $jours;

    #[ORM\Column(type:"date")]
    private $dateExpiration;

    // Getters et setters
    public function getId(): ?int { return $this->id; }

    public function getUser() { return $this->user; }
    public function setUser($user): self { $this->user = $user; return $this; }

    public function getTypeConge(): ?string { return $this->typeConge; }
    public function setTypeConge(string $typeConge): self { $this->typeConge = $typeConge; return $this; }

    public function getJours(): int { return $this->jours; }
    public function setJours(int $jours): self { $this->jours = $jours; return $this; }

    public function getDateExpiration(): \DateTimeInterface { return $this->dateExpiration; }
    public function setDateExpiration(\DateTimeInterface $dateExpiration): self { $this->dateExpiration = $dateExpiration; return $this; }
}