<?php

namespace App\Entity;

use App\Enum\ResourceTypes;
use App\Repository\ResourceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ResourceRepository::class)]
#[Vich\Uploadable]
class Resource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(enumType: ResourceTypes::class)]
    private ?ResourceTypes $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Vich\UploadableField(mapping: "resources", fileNameProperty: "fileUri", size: "fileSize")]
    private ?File $resourceFile = null;

    public function setResourceFile(?File $file = null): void
    {
        $this->resourceFile = $file;
    }

    public function getResourceFile(): ?File
    {
        return $this->resourceFile;
    }

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fileUri = null;

    #[ORM\Column(nullable: true)]
    private ?int $fileSize = null;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?ResourceTypes
    {
        return $this->type;
    }

    public function setType(ResourceTypes $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): static
    {
        $this->fileSize = $fileSize;

        return $this;
    }
}
