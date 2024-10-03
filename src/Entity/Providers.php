<?php

namespace App\Entity;

use App\Enum\ProviderCategories;
use App\Repository\ProvidersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProvidersRepository::class)]
class Providers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $visible = null;

    #[ORM\Column]
    private ?string $location = null;

    #[ORM\Column(type: "string", enumType: ProviderCategories::class)]
    private ?ProviderCategories $category = null;

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

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getCategory(): ?ProviderCategories
    {
        return $this->category;
    }

    public function setCategory(ProviderCategories $category): static
    {
        $this->category = $category;

        return $this;
    }
}
