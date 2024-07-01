<?php

namespace App\Entity;

use App\Repository\AboutMeInfoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AboutMeInfoRepository::class)]
class AboutMeInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $Key = null;

    #[ORM\Column(length: 300)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKey(): ?string
    {
        return $this->Key;
    }

    public function setKey(string $Key): static
    {
        $this->Key = $Key;

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
