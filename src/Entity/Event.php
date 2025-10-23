<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $legacyId = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?Category $category = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTime $creationDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updateDate = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $endDate = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $startAt = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $endAt = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?Location $location = null;

    #[ORM\Column(length: 511, nullable: true)]
    private ?string $legacyAdress = null;

    #[ORM\ManyToOne]
    private ?Contact $contact = null;

    #[ORM\ManyToOne]
    private ?Contact $organisator = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $legacyContactName = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $legacyContactPhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $legacyContactEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $legacyOrganisatorEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $legacyOrganisatorPhone = null;

    #[ORM\Column(length: 511, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(nullable: true)]
    private ?array $links = null;

    #[ORM\Column(length: 511, nullable: true)]
    private ?string $legacyFacebookPage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $source = null;

    #[ORM\Column(nullable: true)]
    private ?float $legacyLat = null;

    #[ORM\Column(nullable: true)]
    private ?float $legacyLng = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cover = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $registrationForm = null;

    #[ORM\Column(length: 511, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isRecurring = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $legacyRecurrence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLegacyId(): ?int
    {
        return $this->legacyId;
    }

    public function setLegacyId(?int $legacyId): static
    {
        $this->legacyId = $legacyId;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

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

    public function getUpdateDate(): ?\DateTime
    {
        return $this->updateDate;
    }

    public function setUpdateDate(?\DateTime $updateDate): static
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStartAt(): ?\DateTime
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTime $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTime
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTime $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getLegacyAdress(): ?string
    {
        return $this->legacyAdress;
    }

    public function setLegacyAdress(?string $legacyAdress): static
    {
        $this->legacyAdress = $legacyAdress;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getOrganisator(): ?Contact
    {
        return $this->organisator;
    }

    public function setOrganisator(?Contact $organisator): static
    {
        $this->organisator = $organisator;

        return $this;
    }

    public function getLegacyContactName(): ?string
    {
        return $this->legacyContactName;
    }

    public function setLegacyContactName(?string $legacyContactName): static
    {
        $this->legacyContactName = $legacyContactName;

        return $this;
    }

    public function getLegacyContactPhone(): ?string
    {
        return $this->legacyContactPhone;
    }

    public function setLegacyContactPhone(?string $legacyContactPhone): static
    {
        $this->legacyContactPhone = $legacyContactPhone;

        return $this;
    }

    public function getLegacyContactEmail(): ?string
    {
        return $this->legacyContactEmail;
    }

    public function setLegacyContactEmail(?string $legacyContactEmail): static
    {
        $this->legacyContactEmail = $legacyContactEmail;

        return $this;
    }

    public function getLegacyOrganisatorEmail(): ?string
    {
        return $this->legacyOrganisatorEmail;
    }

    public function setLegacyOrganisatorEmail(?string $legacyOrganisatorEmail): static
    {
        $this->legacyOrganisatorEmail = $legacyOrganisatorEmail;

        return $this;
    }

    public function getLegacyOrganisatorPhone(): ?string
    {
        return $this->legacyOrganisatorPhone;
    }

    public function setLegacyOrganisatorPhone(?string $legacyOrganisatorPhone): static
    {
        $this->legacyOrganisatorPhone = $legacyOrganisatorPhone;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getLinks(): ?array
    {
        return $this->links;
    }

    public function setLinks(?array $links): static
    {
        $this->links = $links;

        return $this;
    }

    public function getLegacyFacebookPage(): ?string
    {
        return $this->legacyFacebookPage;
    }

    public function setLegacyFacebookPage(?string $legacyFacebookPage): static
    {
        $this->legacyFacebookPage = $legacyFacebookPage;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getLegacyLat(): ?float
    {
        return $this->legacyLat;
    }

    public function setLegacyLat(?float $legacyLat): static
    {
        $this->legacyLat = $legacyLat;

        return $this;
    }

    public function getLegacyLng(): ?float
    {
        return $this->legacyLng;
    }

    public function setLegacyLng(?float $legacyLng): static
    {
        $this->legacyLng = $legacyLng;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getRegistrationForm(): ?string
    {
        return $this->registrationForm;
    }

    public function setRegistrationForm(?string $registrationForm): static
    {
        $this->registrationForm = $registrationForm;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function isRecurring(): ?bool
    {
        return $this->isRecurring;
    }

    public function setIsRecurring(?bool $isRecurring): static
    {
        $this->isRecurring = $isRecurring;

        return $this;
    }

    public function getLegacyRecurrence(): ?string
    {
        return $this->legacyRecurrence;
    }

    public function setLegacyRecurrence(?string $legacyRecurrence): static
    {
        $this->legacyRecurrence = $legacyRecurrence;

        return $this;
    }
}
