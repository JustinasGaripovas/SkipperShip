<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
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


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseUser(): ?User
    {
        return $this->baseUser;
    }

    public function setBaseUser(User $baseUser): self
    {
        $this->baseUser = $baseUser;

        return $this;
    }

}
