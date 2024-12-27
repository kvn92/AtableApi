<?php

namespace App\Entity;

use App\Repository\TypeRepasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

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
    #[Groups(['recette:read'])]
    private ?string $typeRepas = null;

    #[ORM\Column(type:'boolean')]
    #[NotNull()]
    private ?bool $statutTypeRepas = null;

    /**
     * @var Collection<int, Recette>
     */
    #[ORM\OneToMany(targetEntity: Recette::class, mappedBy: 'repas')]
    private Collection $recettes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Recette>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recette $recette): static
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->setRepas($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getRepas() === $this) {
                $recette->setRepas(null);
            }
        }

        return $this;
    }
}
