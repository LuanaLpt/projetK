<?php

namespace App\Entity;

use App\Repository\ArtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: ArtRepository::class)]
#[Assert\Callback('validatePrice')]
class Art
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez inscrire le nom du projet ou produit")]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(message:"Veuillez décrire votre projet ou produit")]
    private ?string $description = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    /**
     * @var Collection<int, MainImage>
     */
    #[ORM\OneToMany(targetEntity: MainImage::class, mappedBy: 'item', cascade: ['remove'], orphanRemoval: true)]
    private Collection $mainImage;

    /**
     * @var Collection<int, TransiImage>
     */
    #[ORM\OneToMany(targetEntity: TransiImage::class, mappedBy: 'item', cascade: ['remove'], orphanRemoval: true)]
    private Collection $transiImages;

    /**
     * @var Collection<int, mainImage>
     */
    #[ORM\OneToMany(targetEntity: MainImage::class, mappedBy: 'item', cascade: ['remove'], orphanRemoval: true)]
    private Collection $mainImages;

    public function __construct()
    {
        $this->mainImage = new ArrayCollection();
        $this->transiImages = new ArrayCollection();
        $this->mainImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, MainImage>
     */
    public function getMainImage(): Collection
    {
        return $this->mainImage;
    }

    public function addMainImage(MainImage $mainImage): static
    {
        if (!$this->mainImage->contains($mainImage)) {
            $this->mainImage->add($mainImage);
            $mainImage->setItem($this);
        }

        return $this;
    }

    public function removeMainImage(MainImage $mainImage): static
    {
        if ($this->mainImage->removeElement($mainImage)) {
            // set the owning side to null (unless already changed)
            if ($mainImage->getItem() === $this) {
                $mainImage->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TransiImage>
     */
    public function getTransiImages(): Collection
    {
        return $this->transiImages;
    }

    public function addTransiImage(TransiImage $transiImage): static
    {
        if (!$this->transiImages->contains($transiImage)) {
            $this->transiImages->add($transiImage);
            $transiImage->setItem($this);
        }

        return $this;
    }

    public function removeTransiImage(TransiImage $transiImage): static
    {
        if ($this->transiImages->removeElement($transiImage)) {
            if ($transiImage->getItem() === $this) {
                $transiImage->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, mainImage>
     */
    public function getMainImages(): Collection
    {
        return $this->mainImages;
    }

    #[Assert\Callback]
    public function validatePrice(ExecutionContextInterface $context): void
    {
        if ($this->getType() === 'Produit' && $this->getPrice() === null) {
            $context->buildViolation('Le prix est obligatoire lorsque vous créez un produit.')
                ->atPath('price')
                ->addViolation();
        }
    }
}
