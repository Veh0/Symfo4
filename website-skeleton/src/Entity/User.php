<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"pseudo"}, message="There is already an account with this pseudo")
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
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="array")
     */
    private $collection = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Command", mappedBy="user_id")
     */
    private $commands;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Streaming", mappedBy="client_id")
     */
    private $streamings;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Actu", mappedBy="userId")
     */
    private $actus;

    public function __construct()
    {
        $this->commands = new ArrayCollection();
        $this->streamings = new ArrayCollection();
        $this->actus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        $roles = $this -> roles;
        
        return array_unique($roles);
    }

    public function setRoles($role): self
    {
        $this -> roles = [];
        $this -> roles[] = $role;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCollection(): ?array
    {
        return $this->collection;
    }

    public function setCollection(array $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function getSalt() {

    }

    public function getUsername() {
        return $this -> pseudo;
    }

    public function eraseCredentials() {

    }

    /**
     * @return Collection|Command[]
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    public function addCommand(Command $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands[] = $command;
            $command->setUserId($this);
        }

        return $this;
    }

    public function removeCommand(Command $command): self
    {
        if ($this->commands->contains($command)) {
            $this->commands->removeElement($command);
            // set the owning side to null (unless already changed)
            if ($command->getUserId() === $this) {
                $command->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Streaming[]
     */
    public function getStreamings(): Collection
    {
        return $this->streamings;
    }

    public function addStreaming(Streaming $streaming): self
    {
        if (!$this->streamings->contains($streaming)) {
            $this->streamings[] = $streaming;
            $streaming->addClientId($this);
        }

        return $this;
    }

    public function removeStreaming(Streaming $streaming): self
    {
        if ($this->streamings->contains($streaming)) {
            $this->streamings->removeElement($streaming);
            $streaming->removeClientId($this);
        }

        return $this;
    }

    /**
     * @return Collection|Actu[]
     */
    public function getActus(): Collection
    {
        return $this->actus;
    }

    public function addActus(Actu $actus): self
    {
        if (!$this->actus->contains($actus)) {
            $this->actus[] = $actus;
            $actus->addUserId($this);
        }

        return $this;
    }

    public function removeActus(Actu $actus): self
    {
        if ($this->actus->contains($actus)) {
            $this->actus->removeElement($actus);
            $actus->removeUserId($this);
        }

        return $this;
    }
}
