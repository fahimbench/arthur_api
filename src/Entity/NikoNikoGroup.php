<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\NikoNikoGroupRepository")
 */
class NikoNikoGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $dateStart;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $dateIgnore;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NikoNikoData", mappedBy="nikoNikoGroups", orphanRemoval=true)
     */
    private $nikoNikoData;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NikoNikoUser", mappedBy="nikoNikoGroups", orphanRemoval=true)
     */
    private $nikoNikoUsers;

    public function __construct()
    {
        $this->nikoNikoData = new ArrayCollection();
        $this->nikoNikoUsers = new ArrayCollection();
        $this->createdAt = new \DateTime();
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getDateIgnore(): ?array
    {
        return $this->dateIgnore;
    }

    public function setDateIgnore(?array $dateIgnore): self
    {
        $this->dateIgnore = $dateIgnore;

        return $this;
    }

    /**
     * @return Collection|NikoNikoData[]
     */
    public function getNikoNikoData(): Collection
    {
        return $this->nikoNikoData;
    }

    public function addNikoNikoData(NikoNikoData $nikoNikoData): self
    {
        if (!$this->nikoNikoData->contains($nikoNikoData)) {
            $this->nikoNikoData[] = $nikoNikoData;
            $nikoNikoData->setNikonikogroups($this);
        }

        return $this;
    }

    public function removeNikoNikoData(NikoNikoData $nikoNikoData): self
    {
        if ($this->nikoNikoData->contains($nikoNikoData)) {
            $this->nikoNikoData->removeElement($nikoNikoData);
            // set the owning side to null (unless already changed)
            if ($nikoNikoData->getNikonikogroups() === $this) {
                $nikoNikoData->setNikonikogroups(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NikoNikoUser[]
     */
    public function getNikoNikoUsers(): Collection
    {
        return $this->nikoNikoUsers;
    }

    public function addNikoNikoUser(NikoNikoUser $nikoNikoUser): self
    {
        if (!$this->nikoNikoUsers->contains($nikoNikoUser)) {
            $this->nikoNikoUsers[] = $nikoNikoUser;
            $nikoNikoUser->setNikoNikoGroup($this);
        }

        return $this;
    }

    public function removeNikoNikoUser(NikoNikoUser $nikoNikoUser): self
    {
        if ($this->nikoNikoUsers->contains($nikoNikoUser)) {
            $this->nikoNikoUsers->removeElement($nikoNikoUser);
            // set the owning side to null (unless already changed)
            if ($nikoNikoUser->getNikoNikoGroup() === $this) {
                $nikoNikoUser->setNikoNikoGroup(null);
            }
        }

        return $this;
    }

}
