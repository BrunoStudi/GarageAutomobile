<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private $IdVoiture;

    #[ORM\Column(type: 'float')]
    private $Prix;

    #[ORM\Column(type: 'string', length: 255)]
    private $ImageUrl;

    #[ORM\Column(type: 'date')]
    private $AnneeCirculation;

    #[ORM\Column(type: 'float')]
    private $Kilometrage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdVoiture(): ?int
    {
        return $this->IdVoiture;
    }

    public function setIdVoiture(int $IdVoiture): self
    {
        $this->IdVoiture = $IdVoiture;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): self
    {
        $this->Prix = $Prix;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->ImageUrl;
    }

    public function setImageUrl(string $ImageUrl): self
    {
        $this->ImageUrl = $ImageUrl;
        return $this;
    }

    public function getAnneeCirculation(): ?\DateTimeInterface
    {
        return $this->AnneeCirculation;
    }

    public function setAnneeCirculation(\DateTimeInterface $AnneeCirculation): self
    {
        $this->AnneeCirculation = $AnneeCirculation;
        return $this;
    }

    public function getKilometrage(): ?float
    {
        return $this->Kilometrage;
    }

    public function setKilometrage(float $Kilometrage): self
    {
        $this->Kilometrage = $Kilometrage;
        return $this;
    }
}
