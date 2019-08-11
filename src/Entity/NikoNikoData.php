<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
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
     */
    private $date_send;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $result;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NikoNikoGroups", inversedBy="nikoNikoData")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nikonikogroups;

    public function getNikonikogroups(): ?NikoNikoGroups
    {
        return $this->nikonikogroups;
    }

    public function setNikonikogroups(?NikoNikoGroups $nikonikogroups): self
    {
        $this->nikonikogroups = $nikonikogroups;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSend(): ?\DateTimeInterface
    {
        return $this->date_send;
    }

    public function setDateSend(\DateTimeInterface $date_send): self
    {
        $this->date_send = $date_send;

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result): self
    {
        $this->result = $result;

        return $this;
    }

}
