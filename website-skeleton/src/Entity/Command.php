<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandRepository")
 */
class Command
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $commandNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $commandDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalPrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commands")
     */
    private $user_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandDetails", mappedBy="commandNumber")
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

    public function getCommandNumber(): ?int
    {
        return $this->commandNumber;
    }

    public function setCommandNumber(int $commandNumber): self
    {
        $this->commandNumber = $commandNumber;

        return $this;
    }

    public function getCommandDate(): ?\DateTimeInterface
    {
        return $this->commandDate;
    }

    public function setCommandDate(\DateTimeInterface $commandDate): self
    {
        $this->commandDate = $commandDate;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

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
            $commandDetail->setCommandNumber($this);
        }

        return $this;
    }

    public function removeCommandDetail(CommandDetails $commandDetail): self
    {
        if ($this->commandDetails->contains($commandDetail)) {
            $this->commandDetails->removeElement($commandDetail);
            // set the owning side to null (unless already changed)
            if ($commandDetail->getCommandNumber() === $this) {
                $commandDetail->setCommandNumber(null);
            }
        }

        return $this;
    }
}
