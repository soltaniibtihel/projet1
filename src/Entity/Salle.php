<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'salles')]
    private ?Departement $name = null;

    #[ORM\Column]
    private ?int $nbrH = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?Departement
    {
        return $this->name;
    }

    public function setName(?Departement $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getNbrH(): ?int
    {
        return $this->nbrH;
    }

    public function setNbrH(int $nbrH): static
    {
        $this->nbrH = $nbrH;

        return $this;
    }
}
