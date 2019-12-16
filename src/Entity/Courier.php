<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourierRepository")
 */
class Courier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="client", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $baseUser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Delivery", mappedBy="courier")
     */
    private $delivery;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Car", inversedBy="courier", cascade={"persist", "remove"})
     */
    private $car;

    public function __construct()
    {
        $this->delivery = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getBaseUser()->getUsername();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseUser(): ?User
    {
        return $this->baseUser;
    }

    public function setBaseUser(?User $baseUser): self
    {
        $this->baseUser = $baseUser;

        return $this;
    }

    /**
     * @return Collection|Delivery[]
     */
    public function getDelivery(): Collection
    {
        return $this->delivery;
    }

    public function addDelivery(Delivery $delivery): self
    {
        if (!$this->delivery->contains($delivery)) {
            $this->delivery[] = $delivery;
            $delivery->setCourier($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): self
    {
        if ($this->delivery->contains($delivery)) {
            $this->delivery->removeElement($delivery);
            // set the owning side to null (unless already changed)
            if ($delivery->getCourier() === $this) {
                $delivery->setCourier(null);
            }
        }

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }
}
