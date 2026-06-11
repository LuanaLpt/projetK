<?php

namespace App\Entity;

use App\Repository\MainImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MainImageRepository::class)]
class MainImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\ManyToOne(inversedBy: 'mainImage')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Art $item = null;

    #[ORM\ManyToOne(inversedBy: 'mainImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Art $art = null;

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

    public function getArt(): ?Art
    {
        return $this->art;
    }

    public function setArt(?Art $art): static
    {
        $this->art = $art;

        return $this;
    }
}
