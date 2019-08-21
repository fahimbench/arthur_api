<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ApiResource()
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "nikonikogroups": "exact", "nikoNikoGroups": "exact"})
 * @ApiFilter(DateFilter::class, properties={"dateSend"})
 * @ORM\Entity(repositoryClass="App\Repository\NikoNikoDataRepository")
 */
class NikoNikoData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $dateSend;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NikoNikoGroup", inversedBy="nikoNikoData")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $nikoNikoGroups;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NikoNikoDataResult", mappedBy="nikoNikoData", orphanRemoval=true)
     */
    private $nikoNikoDataResults;

    public function __construct()
    {
        $this->nikoNikoDataResults = new ArrayCollection();
        $this->dateSend = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSend(): ?\DateTimeInterface
    {
        return $this->dateSend;
    }

    public function setDateSend(\DateTimeInterface $dateSend): self
    {
        $this->dateSend = $dateSend;

        return $this;
    }

    public function getNikonikogroups(): ?NikoNikoGroup
    {
        return $this->nikoNikoGroups;
    }

    public function setNikonikogroups(?NikoNikoGroup $nikoNikoGroups): self
    {
        $this->nikoNikoGroups = $nikoNikoGroups;

        return $this;
    }

    /**
     * @return Collection|NikoNikoDataResult[]
     */
    public function getNikoNikoDataResults(): Collection
    {
        return $this->nikoNikoDataResults;
    }

    public function addNikoNikoDataResult(NikoNikoDataResult $nikoNikoDataResult): self
    {
        if (!$this->nikoNikoDataResults->contains($nikoNikoDataResult)) {
            $this->nikoNikoDataResults[] = $nikoNikoDataResult;
            $nikoNikoDataResult->setNikoNikoData($this);
        }

        return $this;
    }

    public function removeNikoNikoDataResult(NikoNikoDataResult $nikoNikoDataResult): self
    {
        if ($this->nikoNikoDataResults->contains($nikoNikoDataResult)) {
            $this->nikoNikoDataResults->removeElement($nikoNikoDataResult);
            // set the owning side to null (unless already changed)
            if ($nikoNikoDataResult->getNikoNikoData() === $this) {
                $nikoNikoDataResult->setNikoNikoData(null);
            }
        }

        return $this;
    }

}
