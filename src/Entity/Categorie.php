<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    #[Assert\Positive]
    private ?int $id = null;

    #[ORM\Column(type:'string',length: 50,unique:true)]
    #[Assert\NotBlank(message:'Obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Votre mot doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre mot ne peut pas contenir plus de {{ limit }} caractères',
    )]
    private ?string $categories = null;

    #[ORM\Column(type:'boolean')]
    private ?bool $statutCaterogies = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategories(): ?string
    {
        return $this->categories;
    }

    public function setCategories(string $categories): static
    {
        $this->categories = strtolower($categories);

        return $this;
    }

    public function isStatutCaterogies(): ?bool
    {
        return $this->statutCaterogies;
    }

    public function setStatutCaterogies(bool $statutCaterogies): static
    {
        $this->statutCaterogies = $statutCaterogies;

        return $this;
    }
}
