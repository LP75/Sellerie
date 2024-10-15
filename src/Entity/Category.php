<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, EquipmentType>
     */
    #[ORM\OneToMany(targetEntity: EquipmentType::class, mappedBy: 'category_id')]
    private Collection $equipmentTypes;

    public function __construct()
    {
        $this->equipmentTypes = new ArrayCollection();
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

    /**
     * @return Collection<int, EquipmentType>
     */
    public function getEquipmentTypes(): Collection
    {
        return $this->equipmentTypes;
    }

    public function addEquipmentType(EquipmentType $equipmentType): static
    {
        if (!$this->equipmentTypes->contains($equipmentType)) {
            $this->equipmentTypes->add($equipmentType);
            $equipmentType->setCategoryId($this);
        }

        return $this;
    }

    public function removeEquipmentType(EquipmentType $equipmentType): static
    {
        if ($this->equipmentTypes->removeElement($equipmentType)) {
            // set the owning side to null (unless already changed)
            if ($equipmentType->getCategoryId() === $this) {
                $equipmentType->setCategoryId(null);
            }
        }

        return $this;
    }
}
