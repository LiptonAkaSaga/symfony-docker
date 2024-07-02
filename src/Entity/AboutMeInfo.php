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
    private ?string $infoKey = null;

    #[ORM\Column(length: 300)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInfoKey(): ?string
    {
        return $this->infoKey;
    }

    public function setInfoKey(string $infoKey): static
    {
        $this->infoKey = $infoKey;

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
