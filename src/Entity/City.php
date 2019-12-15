<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Warehouse", mappedBy="city", orphanRemoval=true)
     */
    private $warehouse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $crimeRate;

    public function __construct()
    {
        $this->warehouse = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Warehouse[]
     */
    public function getWarehouse(): Collection
    {
        return $this->warehouse;
    }

    public function addWarehouse(Warehouse $warehouse): self
    {
        if (!$this->warehouse->contains($warehouse)) {
            $this->warehouse[] = $warehouse;
            $warehouse->setCity($this);
        }

        return $this;
    }

    public function removeWarehouse(Warehouse $warehouse): self
    {
        if ($this->warehouse->contains($warehouse)) {
            $this->warehouse->removeElement($warehouse);
            // set the owning side to null (unless already changed)
            if ($warehouse->getCity() === $this) {
                $warehouse->setCity(null);
            }
        }

        return $this;
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

    public function getCrimeRate(): ?float
    {
        return $this->crimeRate;
    }

    public function setCrimeRate(float $crimeRate): self
    {
        $this->crimeRate = $crimeRate;

        return $this;
    }
}
