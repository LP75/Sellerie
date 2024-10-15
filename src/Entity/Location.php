<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $aisle = null;

    #[ORM\Column]
    private ?int $shelf = null;

    /**
     * @var Collection<int, EquipmentItem>
     */
    #[ORM\OneToMany(targetEntity: EquipmentItem::class, mappedBy: 'location_id')]
    private Collection $equipmentItems;

    public function __construct()
    {
        $this->equipmentItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAisle(): ?string
    {
        return $this->aisle;
    }

    public function setAisle(string $aisle): static
    {
        $this->aisle = $aisle;

        return $this;
    }

    public function getShelf(): ?int
    {
        return $this->shelf;
    }

    public function setShelf(int $shelf): static
    {
        $this->shelf = $shelf;

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
            $equipmentItem->setLocationId($this);
        }

        return $this;
    }

    public function removeEquipmentItem(EquipmentItem $equipmentItem): static
    {
        if ($this->equipmentItems->removeElement($equipmentItem)) {
            // set the owning side to null (unless already changed)
            if ($equipmentItem->getLocationId() === $this) {
                $equipmentItem->setLocationId(null);
            }
        }

        return $this;
    }
}
