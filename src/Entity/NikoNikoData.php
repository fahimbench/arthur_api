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
     * @ORM\ManyToOne(targetEntity="App\Entity\NikoNikoGroups", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_id_nikonikogroups;

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

    public function getFkIdNikonikogroups(): ?NikoNikoGroups
    {
        return $this->fk_id_nikonikogroups;
    }

    public function setFkIdNikonikogroups(?NikoNikoGroups $fk_id_nikonikogroups): self
    {
        $this->fk_id_nikonikogroups = $fk_id_nikonikogroups;

        return $this;
    }


}
