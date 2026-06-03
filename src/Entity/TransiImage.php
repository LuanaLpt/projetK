<?php

namespace App\Entity;

use App\Repository\TransiImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransiImageRepository::class)]
class TransiImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\ManyToOne(inversedBy: 'transiImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Art $item = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getItem(): ?Art
    {
        return $this->item;
    }

    public function setItem(?Art $item): static
    {
        $this->item = $item;

        return $this;
    }
}
