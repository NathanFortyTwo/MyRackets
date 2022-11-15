<?php

namespace App\Entity;

use App\Repository\TennisManRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TennisManRepository::class)
 */
class TennisMan
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=Inventory::class, inversedBy="tennisMan", cascade={"persist", "remove"})
     */
    private $Inventory;

    /**
     * @ORM\OneToMany(targetEntity=DisplayRack::class, mappedBy="tennisMan")
     */
    private $creator;

    public function __construct()
    {
        $this->creator = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getInventory(): ?Inventory
    {
        return $this->Inventory;
    }

    public function setInventory(?Inventory $Inventory): self
    {
        $this->Inventory = $Inventory;

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection<int, DisplayRack>
     */
    public function getCreator(): Collection
    {
        return $this->creator;
    }

    public function addCreator(DisplayRack $creator): self
    {
        if (!$this->creator->contains($creator)) {
            $this->creator[] = $creator;
            $creator->setTennisMan($this);
        }

        return $this;
    }

    public function removeCreator(DisplayRack $creator): self
    {
        if ($this->creator->removeElement($creator)) {
            // set the owning side to null (unless already changed)
            if ($creator->getTennisMan() === $this) {
                $creator->setTennisMan(null);
            }
        }

        return $this;
    }
}
