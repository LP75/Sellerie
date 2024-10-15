<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $minimum_stock_level = null;

    #[ORM\OneToOne(mappedBy: 'stock', cascade: ['persist', 'remove'])]
    private ?EquipmentType $equipmentType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getMinimumStockLevel(): ?int
    {
        return $this->minimum_stock_level;
    }

    public function setMinimumStockLevel(int $minimum_stock_level): static
    {
        $this->minimum_stock_level = $minimum_stock_level;

        return $this;
    }

    public function getEquipmentType(): ?EquipmentType
    {
        return $this->equipmentType;
    }

    public function setEquipmentType(EquipmentType $equipmentType): static
    {
        // set the owning side of the relation if necessary
        if ($equipmentType->getStock() !== $this) {
            $equipmentType->setStock($this);
        }

        $this->equipmentType = $equipmentType;

        return $this;
    }
}
