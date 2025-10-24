<?php

namespace App\Entity;

use App\Enum\ImportRecurrence;
use App\Enum\ImportSource;
use App\Repository\ImportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImportRepository::class)]
class Import
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(enumType: ImportRecurrence::class)]
    private ?ImportRecurrence $recurrence = null;

    #[ORM\Column(enumType: ImportSource::class)]
    private ?ImportSource $type = null;

    #[ORM\Column(nullable: true)]
    private ?array $conversionTable = null;

    #[ORM\Column(length: 255)]
    private ?string $sourcePath = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $lastOccurenceDate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isActive = null;

    /**
     * @var Collection<int, ImportLog>
     */
    #[ORM\OneToMany(targetEntity: ImportLog::class, mappedBy: 'import')]
    private Collection $importLogs;

    public function __construct()
    {
        $this->importLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRecurrence(): ?ImportRecurrence
    {
        return $this->recurrence;
    }

    public function setRecurrence(ImportRecurrence $recurrence): static
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    public function getType(): ?ImportSource
    {
        return $this->type;
    }

    public function setType(ImportSource $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getConversionTable(): ?array
    {
        return $this->conversionTable;
    }

    public function setConversionTable(?array $conversionTable): static
    {
        $this->conversionTable = $conversionTable;

        return $this;
    }

    public function getSourcePath(): ?string
    {
        return $this->sourcePath;
    }

    public function setSourcePath(string $sourcePath): static
    {
        $this->sourcePath = $sourcePath;

        return $this;
    }

    public function getLastOccurenceDate(): ?\DateTime
    {
        return $this->lastOccurenceDate;
    }

    public function setLastOccurenceDate(?\DateTime $lastOccurenceDate): static
    {
        $this->lastOccurenceDate = $lastOccurenceDate;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, ImportLog>
     */
    public function getImportLogs(): Collection
    {
        return $this->importLogs;
    }

    public function addImportLog(ImportLog $importLog): static
    {
        if (!$this->importLogs->contains($importLog)) {
            $this->importLogs->add($importLog);
            $importLog->setImport($this);
        }

        return $this;
    }

    public function removeImportLog(ImportLog $importLog): static
    {
        if ($this->importLogs->removeElement($importLog)) {
            // set the owning side to null (unless already changed)
            if ($importLog->getImport() === $this) {
                $importLog->setImport(null);
            }
        }

        return $this;
    }
}
