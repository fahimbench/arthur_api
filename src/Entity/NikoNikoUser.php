<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "idSlack": "exact", "nikoNikoGroups": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\NikoNikoUserRepository")
 */
class NikoNikoUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("datagroup")
     */
    private $idSlack;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NikoNikoGroup", inversedBy="nikoNikoUsers")
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    private $nikoNikoGroups;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSlack(): ?string
    {
        return $this->idSlack;
    }

    public function setIdSlack(string $idSlack): self
    {
        $this->idSlack = $idSlack;

        return $this;
    }

    public function getNikoNikoGroups(): ?NikoNikoGroup
    {
        return $this->nikoNikoGroups;
    }

    public function setNikoNikoGroups(?NikoNikoGroup $nikoNikoGroups): self
    {
        $this->nikoNikoGroups = $nikoNikoGroups;

        return $this;
    }
}
