<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\NikoNikoPlannerRepository")
 */
class NikoNikoPlanner
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_start;

    /**
     * @ORM\Column(type="date")
     */
    private $date_end;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $date_ignore;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NikoNikoGroups", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_id_nikonikogroups;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFkIdNikonikogroups(): ?NikoNikoGroups
    {
        return $this->fk_id_nikonikogroups;
    }

    public function setFkIdNikonikogroups(NikoNikoGroups $fk_id_nikonikogroups): self
    {
        $this->fk_id_nikonikogroups = $fk_id_nikonikogroups;

        return $this;
    }
}
