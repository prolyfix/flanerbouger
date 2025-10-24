<?php

namespace App\Entity;

use App\Enum\ImportStatus;
use App\Repository\ImportLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImportLogRepository::class)]
class ImportLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'importLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Import $import = null;

    #[ORM\Column]
    private ?\DateTime $startedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $endedAt = null;

    #[ORM\Column(enumType: ImportStatus::class)]
    private ?ImportStatus $status = null;

    #[ORM\Column(nullable: true)]
    private ?int $processedCount = null;

    #[ORM\Column(nullable: true)]
    private ?int $successCount = null;

    #[ORM\Column(nullable: true)]
    private ?int $errorCount = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $errorDetails = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImport(): ?Import
    {
        return $this->import;
    }

    public function setImport(?Import $import): static
    {
        $this->import = $import;

        return $this;
    }

    public function getStartedAt(): ?\DateTime
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTime $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTime
    {
        return $this->endedAt;
    }

    public function setEndedAt(?\DateTime $endedAt): static
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getStatus(): ?ImportStatus
    {
        return $this->status;
    }

    public function setStatus(ImportStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getProcessedCount(): ?int
    {
        return $this->processedCount;
    }

    public function setProcessedCount(?int $processedCount): static
    {
        $this->processedCount = $processedCount;

        return $this;
    }

    public function getSuccessCount(): ?int
    {
        return $this->successCount;
    }

    public function setSuccessCount(?int $successCount): static
    {
        $this->successCount = $successCount;

        return $this;
    }

    public function getErrorCount(): ?int
    {
        return $this->errorCount;
    }

    public function setErrorCount(?int $errorCount): static
    {
        $this->errorCount = $errorCount;

        return $this;
    }

    public function getErrorDetails(): ?string
    {
        return $this->errorDetails;
    }

    public function setErrorDetails(?string $errorDetails): static
    {
        $this->errorDetails = $errorDetails;

        return $this;
    }
}
