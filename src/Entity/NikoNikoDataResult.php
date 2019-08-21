<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ApiResource()
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "nikoNikoData": "exact", "score": "exact"})
 * @ApiFilter(DateFilter::class, properties={"dateResponse"})
 * @ORM\Entity(repositoryClass="App\Repository\NikoNikoDataResultRepository")
 */
class NikoNikoDataResult
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NikoNikoData", inversedBy="nikoNikoDataResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nikoNikoData;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateResponse;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

    public function __construct()
    {
        $this->dateResponse = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNikoNikoData(): ?NikoNikoData
    {
        return $this->nikoNikoData;
    }

    public function setNikoNikoData(?NikoNikoData $nikoNikoData): self
    {
        $this->nikoNikoData = $nikoNikoData;

        return $this;
    }

    public function getDateResponse(): ?\DateTimeInterface
    {
        return $this->dateResponse;
    }

    public function setDateResponse(\DateTimeInterface $dateResponse): self
    {
        $this->dateResponse = $dateResponse;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
