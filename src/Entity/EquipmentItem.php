<?php

namespace App\Entity;

use App\Repository\EquipmentItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\EquipmentState;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: EquipmentItemRepository::class)]
class EquipmentItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'equipmentItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EquipmentType $equipmentType = null;

    #[ORM\Column]
    private ?bool $isLoaned = null;

    #[ORM\ManyToOne(inversedBy: 'equipmentItems')]
    private ?Location $location = null;

    #[ORM\Column(type: Types::STRING, enumType: EquipmentState::class)]
    private ?EquipmentState $state = null;

    /**
     * @var Collection<int, Repair>
     */
    #[ORM\OneToMany(targetEntity: Repair::class, mappedBy: 'EquipmentItem')]
    private Collection $repairs;

    public function __construct()
    {
        $this->repairs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipmentType(): ?EquipmentType
    {
        return $this->equipmentType;
    }

    public function setEquipmentType(?EquipmentType $equipmentType): static
    {
        $this->equipmentType = $equipmentType;

        return $this;
    }

    public function isLoaned(): ?bool
    {
        return $this->isLoaned;
    }

    public function setLoaned(bool $isLoaned): static
    {
        $this->isLoaned = $isLoaned;

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

    public function getStatus(): ?EquipmentState
    {
        return $this->state;
    }

    public function setStatus(EquipmentState $state): static
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection<int, Repair>
     */
    public function getRepairs(): Collection
    {
        return $this->repairs;
    }

    public function addRepair(Repair $repair): static
    {
        if (!$this->repairs->contains($repair)) {
            $this->repairs->add($repair);
            $repair->setEquipmentItem($this);
        }

        return $this;
    }

    public function removeRepair(Repair $repair): static
    {
        if ($this->repairs->removeElement($repair)) {
            // set the owning side to null (unless already changed)
            if ($repair->getEquipmentItem() === $this) {
                $repair->setEquipmentItem(null);
            }
        }

        return $this;
    }
}
