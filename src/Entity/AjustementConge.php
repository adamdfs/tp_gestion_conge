<?php
// src/Entity/AjustementConge.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AjustementConge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", length:50)]
    private $departement;

    #[ORM\Column(type:"string", length:50)]
    private $typeConge;

    #[ORM\Column(type:"integer")]
    private $ajustement;

    #[ORM\Column(type:"text", nullable:true)]
    private $justification;

    // Getters et setters
    public function getId(): ?int { return $this->id; }

    public function getDepartement(): ?string { return $this->departement; }
    public function setDepartement(string $departement): self { $this->departement = $departement; return $this; }

    public function getTypeConge(): ?string { return $this->typeConge; }
    public function setTypeConge(string $typeConge): self { $this->typeConge = $typeConge; return $this; }

    public function getAjustement(): int { return $this->ajustement; }
    public function setAjustement(int $ajustement): self { $this->ajustement = $ajustement; return $this; }

    public function getJustification(): ?string { return $this->justification; }
    public function setJustification(?string $justification): self { $this->justification = $justification; return $this; }
}