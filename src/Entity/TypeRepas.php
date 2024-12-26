<?php

namespace App\Entity;

use App\Repository\TypeRepasRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TypeRepasRepository::class)]
#[UniqueEntity(
    fields: ['typeRepas'],
    message: 'Cet repas existe déjà. Veuillez en choisir une autre.'
)]
class TypeRepas
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
    private ?string $typeRepas = null;

    #[ORM\Column(type:'boolean')]
    #[NotNull()]
    private ?bool $statutTypeRepas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeRepas(): ?string
    {
        return $this->typeRepas;
    }

    public function setTypeRepas(string $typeRepas): static
    {
        $this->typeRepas = strtolower($typeRepas);

        return $this;
    }

    public function isStatutTypeRepas(): ?bool
    {
        return $this->statutTypeRepas;
    }

    public function setStatutTypeRepas(bool $statutTypeRepas): static
    {
        $this->statutTypeRepas = $statutTypeRepas;

        return $this;
    }
}
