<?php

namespace App\Entity;

use App\Repository\RacketCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RacketCategoryRepository::class)
 */
class RacketCategory
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
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=RacketCategory::class, inversedBy="subShapes")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=RacketCategory::class, mappedBy="parent")
     */
    private $subShapes;

    /**
     * @ORM\ManyToMany(targetEntity=Racket::class, mappedBy="Category")
     */
    private $rackets;

    public function __construct()
    {
        $this->subShapes = new ArrayCollection();
        $this->rackets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubShapes(): Collection
    {
        return $this->subShapes;
    }

    public function addSubShape(self $subShape): self
    {
        if (!$this->subShapes->contains($subShape)) {
            $this->subShapes[] = $subShape;
            $subShape->setParent($this);
        }

        return $this;
    }

    public function removeSubShape(self $subShape): self
    {
        if ($this->subShapes->removeElement($subShape)) {
            // set the owning side to null (unless already changed)
            if ($subShape->getParent() === $this) {
                $subShape->setParent(null);
            }
        }

        return $this;
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
            $racket->addCategory($this);
        }

        return $this;
    }

    public function removeRacket(Racket $racket): self
    {
        if ($this->rackets->removeElement($racket)) {
            $racket->removeCategory($this);
        }

        return $this;
    }
}
