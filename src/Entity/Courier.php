<?php

namespace App\Entity;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $baseUser;

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
}
