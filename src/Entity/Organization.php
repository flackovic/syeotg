<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"school" = "School", "schoolNetwork" = "SchoolNetwork", "district" = "District"})
 *
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Organization
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="organization")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="organizations")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $uuid;

    /**
     * @ORM\OneToMany(targetEntity="Organization", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Organization", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addOrganization($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeOrganization($this);
        }

        return $this;
    }

    /**
     * @return Collection|Organization[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChildOrganization(Organization $organization): self
    {
        if (!$this->children->contains($organization)) {
            $this->children[] = $organization;
            $organization->setParent($this);
        }

        return $this;
    }

    public function removeChildren(Organization $organization): self
    {
        if ($this->children->contains($organization)) {
            $this->children->removeElement($organization);
            $organization->setParent(null);
        }

        return $this;
    }

    public function setParent(Organization $organization): self
    {
        $this->parent = $organization;

        return $this;
    }

    public function getParent(): ?Organization
    {
        return $this->parent;
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

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @return Organization
     * @throws \Exception
     *
     * @ORM\PrePersist()
     */
    public function setUuid(): self
    {
        $this->uuid = Uuid::uuid4();

        return $this;
    }
}
