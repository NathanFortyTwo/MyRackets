<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 */
class Inventory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Racket::class, mappedBy="inventory")
     */
    private $rackets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=TennisMan::class, mappedBy="Inventory", cascade={"persist", "remove"})
     */
    private $tennisMan;

    public function __construct()
    {
        $this->rackets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Racket>
     */
    public function getRackets(): Collection
    {
        return $this->rackets;
    }

    public function addRacket(Racket $racket): self
    {
        if (!$this->rackets->contains($racket)) {
            $this->rackets[] = $racket;
            $racket->setInventory($this);
        }

        return $this;
    }

    public function removeRacket(Racket $racket): self
    {
        if ($this->rackets->removeElement($racket)) {
            // set the owning side to null (unless already changed)
            if ($racket->getInventory() === $this) {
                $racket->setInventory(null);
            }
        }

        return $this;
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

    public function getTennisMan(): ?TennisMan
    {
        return $this->tennisMan;
    }

    public function setTennisMan(?TennisMan $tennisMan): self
    {
        // unset the owning side of the relation if necessary
        if ($tennisMan === null && $this->tennisMan !== null) {
            $this->tennisMan->setInventory(null);
        }

        // set the owning side of the relation if necessary
        if ($tennisMan !== null && $tennisMan->getInventory() !== $this) {
            $tennisMan->setInventory($this);
        }

        $this->tennisMan = $tennisMan;

        return $this;
    }
    public function __toString()
    {
        return $this->description;
    }
}
