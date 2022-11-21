<?php

namespace App\Entity;

use App\Repository\DisplayRackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DisplayRackRepository::class)
 */
class DisplayRack
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
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity=TennisMan::class, inversedBy="creator")
     */
    private $tennisMan;

    /**
     * @ORM\ManyToMany(targetEntity=Racket::class, inversedBy="displayRacks")
     */
    private $rackets;

    public function __construct()
    {
        $this->rackets = new ArrayCollection();
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

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getTennisMan(): ?TennisMan
    {
        return $this->tennisMan;
    }

    public function setTennisMan(?TennisMan $tennisMan): self
    {
        $this->tennisMan = $tennisMan;

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
        }

        return $this;
    }

    public function removeRacket(Racket $racket): self
    {
        $this->rackets->removeElement($racket);

        return $this;
    }

    public function __toString(): string
    {
        return $this->description;
    }
}
