<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;






#[ORM\Entity(repositoryClass: VoitureRepository::class)]
#[Vich\Uploadable]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private $Titre;

    #[ORM\Column(type: 'float')]
    private $Prix;

    #[ORM\Column(type: 'integer')]
    private $AnneeCirculation;

    #[ORM\Column(type: 'float')]
    private $Kilometrage;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: "voiture_images", fileNameProperty: "imageName")]
    #[Assert\Image(mimeTypes: ["image/jpeg", "image/png"])]
    private ?File $imageFile = null;


    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;


    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: "utilisateur_id", referencedColumnName: "id")]
    private ?Utilisateur $utilisateur;


    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;
        return $this;
    }

    public function getAnneeCirculation(): ?int
    {
        return $this->AnneeCirculation;
    }

    public function setAnneeCirculation(int $AnneeCirculation): self
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


    public function getImageFile(): ?UploadedFile
    {
        return $this->imageFile;
    }

    public function setImageFile(?UploadedFile $imageFile): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile !== null) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }



    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
}
