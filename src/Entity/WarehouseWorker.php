<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WarehouseWorkerRepository")
 */
class WarehouseWorker
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Warehouse", inversedBy="workers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warehouse;


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

    public function getWarehouse(): ?Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(?Warehouse $warehouse): self
    {
        $this->warehouse = $warehouse;

        return $this;
    }
}
