<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $taille = null;

    #[ORM\Column(nullable: true)]
    private ?int $dureeDeVie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $artMartial = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Country $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getDureeDeVie(): ?int
    {
        return $this->dureeDeVie;
    }

    public function setDureeDeVie(?int $dureeDeVie): self
    {
        $this->dureeDeVie = $dureeDeVie;

        return $this;
    }

    public function getArtMartial(): ?string
    {
        return $this->artMartial;
    }

    public function setArtMartial(?string $artMartial): self
    {
        $this->artMartial = $artMartial;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}
