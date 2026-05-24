<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'categories')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    #[Assert\Length(
        max: 100,
        maxMessage: "Le nom est trop longue"
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[ORM\ManyToMany(targetEntity: Feature::class, mappedBy: 'categories')]
    private Collection $features;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'categories')]
    private Collection $Products;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    /**
     * @var Collection<int, Brand>
     */
    #[ORM\ManyToMany(targetEntity: Brand::class, mappedBy: 'Categories')]
    private Collection $brands;

    public function __construct()
    {
        $this->features = new ArrayCollection();
        $this->Products = new ArrayCollection();
        $this->brands = new ArrayCollection();
        $this->createdAt = new DateTime();
    }

    public function getFeatures(): Collection
    {
        return $this->features;
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->Products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->Products->contains($product)) {
            $this->Products->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        $this->Products->removeElement($product);

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Brand>
     */
    public function getBrands(): Collection
    {
        return $this->brands;
    }

    public function addBrand(Brand $brand): static
    {
        if (!$this->brands->contains($brand)) {
            $this->brands->add($brand);
            $brand->addCategory($this);
        }

        return $this;
    }

    public function removeBrand(Brand $brand): static
    {
        if ($this->brands->removeElement($brand)) {
            $brand->removeCategory($this);
        }

        return $this;
    }
}
