<?php

namespace App\Entity;

use App\Repository\ProductFeatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductFeatureRepository::class)]
#[ORM\Table(name: 'product_features')]
class ProductFeature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'features')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $feature_id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getFeatureId(): ?string
    {
        return $this->feature_id;
    }

    public function setFeatureId(string $feature_id): static
    {
        $this->feature_id = $feature_id;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }
}
