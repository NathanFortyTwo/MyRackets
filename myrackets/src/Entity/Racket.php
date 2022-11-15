<?php

namespace App\Entity;

use App\Repository\RacketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RacketRepository::class)
 */
class Racket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\ManyToOne(targetEntity=Inventory::class, inversedBy="rackets")
     */
    private $inventory;

    /**
     * @ORM\ManyToMany(targetEntity=RacketCategory::class, inversedBy="rackets")
     */
    private $Category;

    /**
     * @ORM\ManyToMany(targetEntity=DisplayRack::class, mappedBy="rackets")
     */
    private $displayRacks;

    public function __construct()
    {
        $this->Category = new ArrayCollection();
        $this->displayRacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(?Inventory $inventory): self
    {
        $this->inventory = $inventory;

        return $this;
    }
    public function __toString()
    {
        return $this->description;
    }

    /**
     * @return Collection<int, RacketCategory>
     */
    public function getCategory(): Collection
    {
        return $this->Category;
    }

    public function addCategory(RacketCategory $category): self
    {
        if (!$this->Category->contains($category)) {
            $this->Category[] = $category;
        }

        return $this;
    }

    public function removeCategory(RacketCategory $category): self
    {
        $this->Category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, DisplayRack>
     */
    public function getDisplayRacks(): Collection
    {
        return $this->displayRacks;
    }

    public function addDisplayRack(DisplayRack $displayRack): self
    {
        if (!$this->displayRacks->contains($displayRack)) {
            $this->displayRacks[] = $displayRack;
            $displayRack->addRacket($this);
        }

        return $this;
    }

    public function removeDisplayRack(DisplayRack $displayRack): self
    {
        if ($this->displayRacks->removeElement($displayRack)) {
            $displayRack->removeRacket($this);
        }

        return $this;
    }
}
