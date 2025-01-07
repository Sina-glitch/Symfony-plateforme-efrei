<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $benevole = null;
    

    #[ORM\ManyToOne(targetEntity: Offre::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $offre = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $statut = 'En attente';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBenevole(): ?User
    {
        return $this->benevole;
    }

    public function setBenevole(?User $benevole): self
    {
        $this->benevole = $benevole;
        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }
}
