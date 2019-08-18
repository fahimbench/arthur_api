<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\NikoNikoGroupsRepository")
 */
class NikoNikoGroups
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
     * @ORM\Column(type="json_array")
     * @Assert\NotBlank
     */
    private $users;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $date_start;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $date_end;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $date_ignore;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NikoNikoData", mappedBy="nikonikogroups", orphanRemoval=true)
     */
    private $nikoNikoData;

    public function __construct()
    {
        $this->nikoNikoData = new ArrayCollection();
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

    public function getUsers()
    {
        return $this->users;
    }

    public function setUsers($users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getDateIgnore()
    {
        return $this->date_ignore;
    }

    public function setDateIgnore($date_ignore): self
    {
        $this->date_ignore = $date_ignore;

        return $this;
    }

}
