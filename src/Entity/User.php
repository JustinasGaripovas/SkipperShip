<?php

namespace App\Entity;

use App\Constants\RoleConst;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $encodedPassword;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client", mappedBy="baseUser", cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Admin", mappedBy="baseUser", cascade={"persist", "remove"})
     */
    private $admin;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Courier", mappedBy="baseUser", cascade={"persist", "remove"})
     */
    private $courier;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\WarehouseWorker", mappedBy="baseUser", cascade={"persist", "remove"})
     */
    private $warehouseWorker;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function setPassword(string $password_encoded): self
    {
        $this->encodedPassword = $password_encoded;

        return $this;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->encodedPassword;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        // set the owning side of the relation if necessary
        if ($client->getBaseUser() !== $this) {
            $client->setBaseUser($this);
        }

        return $this;
    }
    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(Admin $admin): self
    {
        $this->admin = $admin;

        // set the owning side of the relation if necessary
        if ($admin->getBaseUser() !== $this) {
            $admin->setBaseUser($this);
        }

        return $this;
    }
    public function getCourier(): ?Courier
    {
        return $this->courier;
    }

    public function setCourier(Courier $courier): self
    {
        $this->courier = $courier;

        // set the owning side of the relation if necessary
        if ($courier->getBaseUser() !== $this) {
            $courier->setBaseUser($this);
        }

        return $this;
    }
    public function getWarehouseWorker(): ?WarehouseWorker
    {
        return $this->warehouseWorker;
    }

    public function setWarehouseWorker(WarehouseWorker $warehouseWorker): self
    {
        $this->warehouseWorker = $warehouseWorker;

        // set the owning side of the relation if necessary
        if ($warehouseWorker->getBaseUser() !== $this) {
            $warehouseWorker->setBaseUser($this);
        }

        return $this;
    }
}
