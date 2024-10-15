<?php

namespace App\Entity;

use App\Repository\EquipmentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentTypeRepository::class)]
class EquipmentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'equipmentTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category_id = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column]
    private ?float $unit_price = null;

    #[ORM\OneToOne(inversedBy: 'equipmentType', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stock $stock_id = null;

    /**
     * @var Collection<int, EquipmentItem>
     */
    #[ORM\OneToMany(targetEntity: EquipmentItem::class, mappedBy: 'equipmentType_id')]
    private Collection $equipmentItems;

    public function __construct()
    {
        $this->equipmentItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getCategoryId(): ?Category
    {
        return $this->category_id;
    }

    public function setCategoryId(?Category $category_id): static
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unit_price;
    }

    public function setUnitPrice(float $unit_price): static
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    public function getStockId(): ?Stock
    {
        return $this->stock_id;
    }

    public function setStockId(Stock $stock_id): static
    {
        $this->stock_id = $stock_id;

        return $this;
    }

    /**
     * @return Collection<int, EquipmentItem>
     */
    public function getEquipmentItems(): Collection
    {
        return $this->equipmentItems;
    }

    public function addEquipmentItem(EquipmentItem $equipmentItem): static
    {
        if (!$this->equipmentItems->contains($equipmentItem)) {
            $this->equipmentItems->add($equipmentItem);
            $equipmentItem->setEquipmentTypeId($this);
        }

        return $this;
    }

    public function removeEquipmentItem(EquipmentItem $equipmentItem): static
    {
        if ($this->equipmentItems->removeElement($equipmentItem)) {
            // set the owning side to null (unless already changed)
            if ($equipmentItem->getEquipmentTypeId() === $this) {
                $equipmentItem->setEquipmentTypeId(null);
            }
        }

        return $this;
    }
}
