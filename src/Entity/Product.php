<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: "products")]
    private ?Provider $provider = null;

    #[ORM\Column]
    private ?float $price = null;

    #[Vich\UploadableField(mapping: "products", fileNameProperty: "fileUri", size: "fileSize")]
    private ?File $productImage = null;

    public function setProductImage(?File $file = null): void
    {
        $this->fileSize = $file->getSize();
        $this->productImage = $file;
    }

    public function getProductImage(): ?File
    {
        return $this->productImage;
    }

    #[ORM\Column(nullable: true)]
    private ?int $fileSize = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fileUri = null;

    #[ORM\Column]
    private ?bool $promote = null;

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): static
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getFileUri(): ?string
    {
        return $this->fileUri;
    }

    public function setFileUri(?string $fileUri): static
    {
        $this->fileUri = $fileUri;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    public function setProvider(?Provider $provider): static
    {
        $this->provider = $provider;

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

    public function isPromote(): ?bool
    {
        return $this->promote;
    }

    public function setPromote(bool $promote): static
    {
        $this->promote = $promote;

        return $this;
    }
}
