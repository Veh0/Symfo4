<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandDetailsRepository")
 */
class CommandDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Command", inversedBy="commandDetails")
     */
    private $commandNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Support", inversedBy="commandDetails")
     */
    private $support_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandNumber(): ?Command
    {
        return $this->commandNumber;
    }

    public function setCommandNumber(?Command $commandNumber): self
    {
        $this->commandNumber = $commandNumber;

        return $this;
    }

    public function getSupportId(): ?Support
    {
        return $this->support_id;
    }

    public function setSupportId(?Support $support_id): self
    {
        $this->support_id = $support_id;

        return $this;
    }
}
