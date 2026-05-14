<?php

namespace App\Entity;

use App\Repository\FeatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: FeatureRepository::class)]
#[ORM\Table(name: 'features')]
class Feature
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

    #[ORM\Column(length: 20)]
    #[Assert\Choice(choices: ['free', 'options'])]
    private ?string $type = null;

    #[ORM\OneToMany(
        mappedBy: 'feature',
        targetEntity: FeatureValue::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $options;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'features')]
    #[ORM\JoinTable(name: 'feature_category')]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->options = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);
        return $this;
    }

    /**
     * @return Collection<int, FeatureValue>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(FeatureValue $option): static
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
            $option->setFeature($this);
        }

        return $this;
    }

    public function removeOption(FeatureValue $option): static
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getFeature() === $this) {
                $option->setFeature(null);
            }
        }

        return $this;
    }
}
