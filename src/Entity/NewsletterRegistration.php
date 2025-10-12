<?php

namespace App\Entity;

use App\Helper\StringHelper;
use App\Repository\NewsletterRegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterRegistrationRepository::class)]
class NewsletterRegistration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?\DateTime $creationDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $optinValidationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $uniqIdentification = null;

    public function __construct()
    {
        $this->creationDate = new \DateTime();
        $this->uniqIdentification = StringHelper::generateUniqueId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCreationDate(): ?\DateTime
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getOptinValidationDate(): ?\DateTime
    {
        return $this->optinValidationDate;
    }

    public function setOptinValidationDate(?\DateTime $optinValidationDate): static
    {
        $this->optinValidationDate = $optinValidationDate;

        return $this;
    }

    public function getUniqIdentification(): ?string
    {
        return $this->uniqIdentification;
    }

    public function setUniqIdentification(string $uniqIdentification): static
    {
        $this->uniqIdentification = $uniqIdentification;

        return $this;
    }
}
