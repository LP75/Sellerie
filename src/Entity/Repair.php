<?php

namespace App\Entity;

use App\Repository\RepairRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepairRepository::class)]
class Repair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'repairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EquipmentItem $EquipmentItem = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $cost = null;

    #[ORM\Column]
    private ?\DateInterval $repairTime = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getRepairTime(): ?\DateInterval
    {
        return $this->repairTime;
    }

    public function setRepairTime(\DateInterval $repairTime): static
    {
        $this->repairTime = $repairTime;

        return $this;
    }
}
