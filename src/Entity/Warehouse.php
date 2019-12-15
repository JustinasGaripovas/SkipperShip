<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WarehouseRepository")
 */
class Warehouse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="warehouse")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Delivery", mappedBy="warehouse")
     */
    private $deliveries;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WarehouseWorker", mappedBy="warehouse", orphanRemoval=true)
     */
    private $workers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $postCode;

    public function __construct()
    {
        $this->deliveries = new ArrayCollection();
        $this->workers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Delivery[]
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): self
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries[] = $delivery;
            $delivery->setWarehouse($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): self
    {
        if ($this->deliveries->contains($delivery)) {
            $this->deliveries->removeElement($delivery);
            // set the owning side to null (unless already changed)
            if ($delivery->getWarehouse() === $this) {
                $delivery->setWarehouse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WarehouseWorker[]
     */
    public function getWorkers(): Collection
    {
        return $this->workers;
    }

    public function addWorker(WarehouseWorker $worker): self
    {
        if (!$this->workers->contains($worker)) {
            $this->workers[] = $worker;
            $worker->setWarehouse($this);
        }

        return $this;
    }

    public function removeWorker(WarehouseWorker $worker): self
    {
        if ($this->workers->contains($worker)) {
            $this->workers->removeElement($worker);
            // set the owning side to null (unless already changed)
            if ($worker->getWarehouse() === $this) {
                $worker->setWarehouse(null);
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

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }
}
