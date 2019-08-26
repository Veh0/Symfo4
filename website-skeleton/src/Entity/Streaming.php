<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StreamingRepository")
 */
class Streaming
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
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $quality;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="streamings")
     */
    private $product_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="streamings")
     */
    private $client_id;

    public function __construct()
    {
        $this->client_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuality(): ?string
    {
        return $this->quality;
    }

    public function setQuality(string $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getProductId(): ?Product
    {
        return $this->product_id;
    }

    public function setProductId(?Product $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getClientId(): Collection
    {
        return $this->client_id;
    }

    public function addClientId(User $clientId): self
    {
        if (!$this->client_id->contains($clientId)) {
            $this->client_id[] = $clientId;
        }

        return $this;
    }

    public function removeClientId(User $clientId): self
    {
        if ($this->client_id->contains($clientId)) {
            $this->client_id->removeElement($clientId);
        }

        return $this;
    }
}
