<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryRepository")
 */
class Delivery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="delivery")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Courier", inversedBy="delivery")
     */
    private $courier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Warehouse", inversedBy="deliveries")
     */
    private $warehouse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Lng;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recipientLat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recipientLng;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="float")
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recipientInformation;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCourier(): ?Courier
    {
        return $this->courier;
    }

    public function setCourier(?Courier $courier): self
    {
        $this->courier = $courier;

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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->Lng;
    }

    public function setLng(?string $Lng): self
    {
        $this->Lng = $Lng;

        return $this;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getRecipientInformation(): ?string
    {
        return $this->recipientInformation;
    }

    public function setRecipientInformation(string $recipientInformation): self
    {
        $this->recipientInformation = $recipientInformation;

        return $this;
    }

    public function getRecipientLat(): ?string
    {
        return $this->recipientLat;
    }

    public function setRecipientLat(?string $lat): self
    {
        $this->recipientLat = $lat;

        return $this;
    }

    public function getRecipientLng(): ?string
    {
        return $this->recipientLng;
    }

    public function setRecipientLng(?string $Lng): self
    {
        $this->recipientLng = $Lng;

        return $this;
    }

    public function getStatus(): ?string
    {
        switch ($this->status) {
            case 0:
                return "ORDERED";
                break;
            case 1:
                return "IN STORAGE";
                break;
            case 2:
                return "IN TRANSIT";
                break;
            case 3:
                return "CANCELED";
                break;
            case 4:
                return "DELIVERED";
                break;

            default:
                return "ERROR";

        }

        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
