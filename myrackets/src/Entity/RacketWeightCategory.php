<?php

namespace App\Entity;

use App\Repository\RacketWeightCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RacketWeightCategoryRepository::class)
 */
class RacketWeightCategory
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
     * @ORM\ManyToOne(targetEntity=RacketWeightCategory::class, inversedBy="subRacketWeights")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=RacketWeightCategory::class, mappedBy="parent")
     */
    private $subRacketWeights;

    /**
     * @ORM\ManyToMany(targetEntity=Racket::class, mappedBy="WeightCategory")
     */
    private $rackets;

    public function __construct()
    {
        $this->subRacketWeights = new ArrayCollection();
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
    public function getSubRacketWeights(): Collection
    {
        return $this->subRacketWeights;
    }

    public function addSubRacketWeight(self $subRacketWeight): self
    {
        if (!$this->subRacketWeights->contains($subRacketWeight)) {
            $this->subRacketWeights[] = $subRacketWeight;
            $subRacketWeight->setParent($this);
        }

        return $this;
    }

    public function removeSubRacketWeight(self $subRacketWeight): self
    {
        if ($this->subRacketWeights->removeElement($subRacketWeight)) {
            // set the owning side to null (unless already changed)
            if ($subRacketWeight->getParent() === $this) {
                $subRacketWeight->setParent(null);
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
            $racket->addWeightCategory($this);
        }

        return $this;
    }

    public function removeRacket(Racket $racket): self
    {
        if ($this->rackets->removeElement($racket)) {
            $racket->removeWeightCategory($this);
        }

        return $this;
    }
}
