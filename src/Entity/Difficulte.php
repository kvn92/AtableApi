<?php

namespace App\Entity;

use App\Repository\DifficulteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: DifficulteRepository::class)]
#[UniqueEntity(
    fields: ['difficultes'],
    message: 'Ce niveau existe déjà. Veuillez en choisir une autre.'
)]
class Difficulte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    private ?int $id = null;

    #[ORM\Column(type:'string',length: 50,unique:true)]
    #[NotBlank(message:'Obligatoire')]
    #[Assert\Length( 
        min: 2,
        max: 50,
        minMessage: 'Votre mot doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre mot ne peut pas contenir plus de {{ limit }} caractères',
    )]
    private ?string $difficultes = null;

    #[ORM\Column(type:'boolean')]
 
    private ?bool $statutDifficultes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDifficultes(): ?string
    {
        return $this->difficultes;
    }

    public function setDifficultes(string $difficultes): static
    {
        $this->difficultes = strtolower($difficultes);

        return $this;
    }

    public function isStatutDifficultes(): ?bool
    {
        return $this->statutDifficultes;
    }

    public function setStatutDifficultes(bool $statutDifficultes): static
    {
        $this->statutDifficultes = $statutDifficultes;

        return $this;
    }
}
