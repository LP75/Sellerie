<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoanRepository::class)]
class Loan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Loan')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_loaned = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_due = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateLoaned(): ?\DateTimeInterface
    {
        return $this->date_loaned;
    }

    public function setDateLoaned(\DateTimeInterface $date_loaned): static
    {
        $this->date_loaned = $date_loaned;

        return $this;
    }

    public function getDateDue(): ?\DateTimeInterface
    {
        return $this->date_due;
    }

    public function setDateDue(\DateTimeInterface $date_due): static
    {
        $this->date_due = $date_due;

        return $this;
    }
}
