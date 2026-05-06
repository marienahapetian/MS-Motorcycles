<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    #[Assert\Length(
        max: 100,
        maxMessage: "Le titre est trop longue"
    )]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Brand::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Veuillez sélectionner une marque")]
    #[Assert\Type(Brand::class)]
    private ?Brand $brand = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(
        type: 'integer',
        message: 'L\'année doit être un nombre entier'
    )]
    #[Assert\Range(
        min: 1900,
        max: 2026,
        notInRangeMessage: 'L\'année doit être entre {{ min }} et {{ max }}'
    )]
    private ?int $year = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(
        type: 'numeric',
        message: 'Le prix doit être un nombre'
    )]
    #[Assert\PositiveOrZero(message: 'Le prix doit être positif')]
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Type('string')]
    #[Assert\Length(
        max: 1000,
        maxMessage: "Le a propos est trop longue"

    )]
    private ?string $description = null;

    #[ORM\OneToMany(
        mappedBy: 'product',
        targetEntity: ProductImage::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $images;

    #[ORM\ManyToMany(
        mappedBy: 'product',
        targetEntity: ProductFeature::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $features;

    #[ORM\Column]
    private ?\DateTime $added = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $modified = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'Products')]
    private Collection $categories;


    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->features = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return str_replace(' ', '_', strtolower($this->name));
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImages(): ?Collection
    {
        return $this->images;
    }

    public function setImages(Collection $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function addImage(ProductImage $image): self
    {
        $this->images[] = $image;
        $image->setProduct($this);
        return $this;
    }

    public function getMainImage(): ?ProductImage
    {
        foreach ($this->images as $image) {
            if ($image->isMain()) {
                return $image;
            }
        }

        return null;
    }

    public function getGalleryImages(): ?Collection
    {
        return $this->images->filter(function (ProductImage $image) {
            return !$image->isMain();
        });
    }

    public function getFeatures(): ?Collection
    {
        return $this->features;
    }

    public function setFeatures(Collection $features): self
    {
        $this->features = $features;

        return $this;
    }

    public function getAdded(): ?\DateTime
    {
        return $this->added;
    }

    public function setAdded(\DateTime $added): static
    {
        $this->added = $added;

        return $this;
    }

    public function getModified(): ?\DateTime
    {
        return $this->modified;
    }

    public function setModified(?\DateTime $modified): static
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addProduct($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeProduct($this);
        }

        return $this;
    }
}
