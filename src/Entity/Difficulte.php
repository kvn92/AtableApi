<?php

namespace App\Entity;

use App\Repository\DifficulteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;


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
    #[Groups(['recette:read'])]
    private ?string $difficultes = null;

    #[ORM\Column(type:'boolean')]
 
    private ?bool $statutDifficultes = null;

    /**
     * @var Collection<int, Recette>
     */
    #[ORM\OneToMany(targetEntity: Recette::class, mappedBy: 'difficultes')]
    private Collection $recettes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
    }

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
            $recette->setDifficultes($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getDifficultes() === $this) {
                $recette->setDifficultes(null);
            }
        }

        return $this;
    }
}
