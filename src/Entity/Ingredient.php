<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\IngredientRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[UniqueEntity(fields: 'name', message: 'Un ingrédient avec le même nom existe déjà.')]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(
        message: 'Le nom de l\'ingrédient ne peut pas être nul.',
    )]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom de l\'ingrédient doit comporter au minimum {{ limit }} caractères',
        maxMessage: 'Le nom de l\'ingrédient doit comporter au maximum {{ limit }} caractères',
    )]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\Positive(
        message: 'Le prix de l\'ingrédient doit être positif.',
    )]
    #[Assert\LessThan(
        value: 200,
        message: 'Le prix de l\'ingrédient doit être inférieur à {{ value }} €.',
    )]
    private ?float $price = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
