<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupportRepository")
 */
class Support
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
    private $typeSupport;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="supports")
     */
    private $product_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandDetails", mappedBy="support_id")
     */
    private $commandDetails;

    public function __construct()
    {
        $this->commandDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeSupport(): ?string
    {
        return $this->typeSupport;
    }

    public function setTypeSupport(string $typeSupport): self
    {
        $this->typeSupport = $typeSupport;

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
     * @return Collection|CommandDetails[]
     */
    public function getCommandDetails(): Collection
    {
        return $this->commandDetails;
    }

    public function addCommandDetail(CommandDetails $commandDetail): self
    {
        if (!$this->commandDetails->contains($commandDetail)) {
            $this->commandDetails[] = $commandDetail;
            $commandDetail->setSupportId($this);
        }

        return $this;
    }

    public function removeCommandDetail(CommandDetails $commandDetail): self
    {
        if ($this->commandDetails->contains($commandDetail)) {
            $this->commandDetails->removeElement($commandDetail);
            // set the owning side to null (unless already changed)
            if ($commandDetail->getSupportId() === $this) {
                $commandDetail->setSupportId(null);
            }
        }

        return $this;
    }
}
