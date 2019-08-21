<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ApiResource()
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "user": "exact", "questionData": "exact"})
 * @ApiFilter(DateFilter::class, properties={"dateSend"})
 * @ORM\Entity(repositoryClass="App\Repository\QuestionLadderRepository")
 */
class QuestionLadder
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
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionData", inversedBy="questionLadders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $questionData;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateSend;

    public function __construct()
    {
        $this->dateSend = new \DateTime();
    }

    public function getQuestionData(): ?QuestionData
    {
        return $this->questionData;
    }

    public function setQuestionData(?QuestionData $questionData): self
    {
        $this->questionData = $questionData;

        return $this;
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }


}
