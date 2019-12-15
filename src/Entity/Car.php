<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Courier", mappedBy="car", cascade={"persist", "remove"})
     */
    private $courier;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $weightCategoty;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $plateNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourier(): ?Courier
    {
        return $this->courier;
    }

    public function setCourier(?Courier $courier): self
    {
        $this->courier = $courier;

        // set (or unset) the owning side of the relation if necessary
        $newCar = null === $courier ? null : $this;
        if ($courier->getCar() !== $newCar) {
            $courier->setCar($newCar);
        }

        return $this;
    }

    public function getWeightCategoty(): ?string
    {
        return $this->weightCategoty;
    }

    public function setWeightCategoty(string $weightCategoty): self
    {
        $this->weightCategoty = $weightCategoty;

        return $this;
    }

    public function getPlateNumber(): ?string
    {
        return $this->plateNumber;
    }

    public function setPlateNumber(string $plateNumber): self
    {
        $this->plateNumber = $plateNumber;

        return $this;
    }
}
