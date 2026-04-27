<?php

namespace App\Entity;

use App\Repository\WebsiteSettingsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteSettingsRepository::class)]
#[ORM\Table(name: 'website_settings')]
class WebsiteSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagram_link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tweeter_link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tiktok_link = null;

    #[ORM\Column(length: 255)]
    private ?string $font = null;

    #[ORM\Column(length: 255)]
    private ?string $accent_color = null;

    #[ORM\Column(length: 255)]
    private ?string $black_color = null;

    #[ORM\Column(length: 255)]
    private ?string $white_color = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $location = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstagramLink(): ?string
    {
        return $this->instagram_link;
    }

    public function setInstagramLink(?string $instagram_link): static
    {
        $this->instagram_link = $instagram_link;

        return $this;
    }

    public function getTweeterLink(): ?string
    {
        return $this->tweeter_link;
    }

    public function setTweeterLink(?string $tweeter_link): static
    {
        $this->tweeter_link = $tweeter_link;

        return $this;
    }

    public function getTiktokLink(): ?string
    {
        return $this->tiktok_link;
    }

    public function setTiktokLink(?string $tiktok_link): static
    {
        $this->tiktok_link = $tiktok_link;

        return $this;
    }

    public function getFont(): ?string
    {
        return $this->font;
    }

    public function setFont(string $font): static
    {
        $this->font = $font;

        return $this;
    }

    public function getAccentColor(): ?string
    {
        return $this->accent_color;
    }

    public function setAccentColor(string $accent_color): static
    {
        $this->accent_color = $accent_color;

        return $this;
    }

    public function getBlackColor(): ?string
    {
        return $this->black_color;
    }

    public function setBlackColor(string $black_color): static
    {
        $this->black_color = $black_color;

        return $this;
    }

    public function getWhiteColor(): ?string
    {
        return $this->white_color;
    }

    public function setWhiteColor(string $white_color): static
    {
        $this->white_color = $white_color;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }
}
