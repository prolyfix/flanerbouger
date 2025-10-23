<?php

namespace App\Entity;

use App\Repository\PostcodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostcodeRepository::class)]
class Postcode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postcodes')]
    private ?city $city = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?city
    {
        return $this->city;
    }

    public function setCity(?city $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }
}
