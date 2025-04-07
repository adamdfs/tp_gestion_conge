<?php

namespace App\Entity;

use App\Repository\RegleReportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegleReportRepository::class)]
class RegleReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Type de congé (ex: RTT, CP, etc.).
     * Vous pouvez en faire une relation vers une entité TypeConge si vous préférez.
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $typeConge = null;

    /**
     * Département (ex: 'RH', 'IT', 'Finance', etc.).
     * Vous pouvez aussi faire une relation vers une entité Department.
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $departement = null;

    /**
     * Plafond maximum de jours reportables (ex: 10 jours).
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $plafond = null;

    /**
     * Date limite d'utilisation des jours reportés.
     * Exemple : 31/03/N+1
     */
    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateLimiteUtilisation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeConge(): ?string
    {
        return $this->typeConge;
    }

    public function setTypeConge(string $typeConge): self
    {
        $this->typeConge = $typeConge;
        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;
        return $this;
    }

    public function getPlafond(): ?int
    {
        return $this->plafond;
    }

    public function setPlafond(?int $plafond): self
    {
        $this->plafond = $plafond;
        return $this;
    }

    public function getDateLimiteUtilisation(): ?\DateTimeInterface
    {
        return $this->dateLimiteUtilisation;
    }

    public function setDateLimiteUtilisation(?\DateTimeInterface $dateLimiteUtilisation): self
    {
        $this->dateLimiteUtilisation = $dateLimiteUtilisation;
        return $this;
    }
}