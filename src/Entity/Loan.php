<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Movement>
     */
    #[ORM\OneToMany(targetEntity: Movement::class, mappedBy: 'loan')]
    private Collection $movements;

    #[ORM\ManyToOne(inversedBy: 'loans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EquipmentItem $EquipmentItem = null;

    public function __construct()
    {
        $this->movements = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Movement>
     */
    public function getMovements(): Collection
    {
        return $this->movements;
    }

    public function addMovement(Movement $movement): static
    {
        if (!$this->movements->contains($movement)) {
            $this->movements->add($movement);
            $movement->setLoan($this);
        }

        return $this;
    }

    public function removeMovement(Movement $movement): static
    {
        if ($this->movements->removeElement($movement)) {
            // set the owning side to null (unless already changed)
            if ($movement->getLoan() === $this) {
                $movement->setLoan(null);
            }
        }

        return $this;
    }

    public function getEquipmentItem(): ?EquipmentItem
    {
        return $this->EquipmentItem;
    }

    public function setEquipmentItem(?EquipmentItem $EquipmentItem): static
    {
        $this->EquipmentItem = $EquipmentItem;

        return $this;
    }
}
