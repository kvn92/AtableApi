<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;




#[ORM\Entity(repositoryClass: RecetteRepository::class)]
#[UniqueEntity(
    fields: ['titreRecettes'],
    message: 'Cette Recette existe déjà. Veuillez en choisir une autre.'
)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    #[Groups(['recette:read'])] 

    private ?int $id = null;

    #[ORM\Column(type:'string',length: 50,unique:true)]
    #[Assert\Length( 
        min: 2,
        max: 50,
        minMessage: 'Votre mot doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre mot ne peut pas contenir plus de {{ limit }} caractères',
    )]
    #[NotBlank(message:'Obligatoire')]
    #[Groups(['recette:read'])] 

    private ?string $titreRecettes = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length( 
        min: 2,
        max: 50,
        minMessage: 'Votre mot doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre mot ne peut pas contenir plus de {{ limit }} caractères',
    )]
    #[Groups(['recette:read'])] 
    private ?string $preparations = null;

    #[ORM\Column(type:'integer',nullable: true)]
    #[Groups(['recette:read'])] 

    private ?int $nbrLikes = null;

    #[ORM\Column(type:'boolean')]
    #[Groups(['recette:read'])] 

    private ?bool $statutRecettes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['recette:read'])] 

    private ?\DateTimeInterface $dateRecettes = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    #[Groups(['recette:read'])] 

    private ?Categorie $categories = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    #[Groups(['recette:read'])] 

    private ?Difficulte $difficultes = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    #[Groups(['recette:read'])] 

    private ?TypeRepas $repas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreRecettes(): ?string
    {
        return $this->titreRecettes;
    }

    public function setTitreRecettes(string $titreRecettes): static
    {
        $this->titreRecettes = strtolower($titreRecettes);

        return $this;
    }

    public function getPreparations(): ?string
    {
        return $this->preparations;
    }

    public function setPreparations(string $preparations): static
    {
        $this->preparations = $preparations;

        return $this;
    }

    public function getNbrLikes(): ?int
    {
        return $this->nbrLikes;
    }

    public function setNbrLikes(?int $nbrLikes): static
    {
        $this->nbrLikes = intval($nbrLikes);

        return $this;
    }

    public function isStatutRecettes(): ?bool
    {
        return $this->statutRecettes;
    }

    public function setStatutRecettes(bool $statutRecettes): static
    {
        $this->statutRecettes = $statutRecettes;

        return $this;
    }

    public function getDateRecettes(): ?\DateTimeInterface
    {
        return $this->dateRecettes;
    }

    public function setDateRecettes(?\DateTimeInterface $dateRecettes): static
    {
        $this->dateRecettes = $dateRecettes;

        return $this;
    }

    public function getCategories(): ?Categorie
    {
        return $this->categories;
    }

    public function setCategories(?Categorie $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function getDifficultes(): ?Difficulte
    {
        return $this->difficultes;
    }

    public function setDifficultes(?Difficulte $difficultes): static
    {
        $this->difficultes = $difficultes;

        return $this;
    }

    public function getRepas(): ?TypeRepas
    {
        return $this->repas;
    }

    public function setRepas(?TypeRepas $repas): static
    {
        $this->repas = $repas;

        return $this;
    }
}
