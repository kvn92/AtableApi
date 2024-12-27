<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    #[Groups(['commentaire:read'])]

    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Recette $recettes = null;

    #[ORM\Column(type: Types::TEXT)]
    #[NotBlank()]
    #[Groups(['commentaire:read'])]
    private ?string $commentaires = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCommentaires = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecettes(): ?Recette
    {
        return $this->recettes;
    }

    public function setRecettes(?Recette $recettes): static
    {
        $this->recettes = $recettes;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(string $commentaires): static
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getDateCommentaires(): ?\DateTimeInterface
    {
        return $this->dateCommentaires;
    }

    public function setDateCommentaires(\DateTimeInterface $dateCommentaires): static
    {
        $this->dateCommentaires = $dateCommentaires;

        return $this;
    }
}
