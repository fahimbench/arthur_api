<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(normalizationContext={"groups"={"question"}})
 * @ORM\Entity(repositoryClass="App\Repository\QuestionDataRepository")
 */
class QuestionData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("question")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("question")
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("question")
     */
    private $answers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("question")
     */
    private $resultText;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionTheme", inversedBy="questionData")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Groups("question")
     */
    private $questionTheme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswers(): ?string
    {
        return $this->answers;
    }

    public function setAnswers(string $answers): self
    {
        $this->answers = $answers;

        return $this;
    }

    public function getResultText(): ?string
    {
        return $this->resultText;
    }

    public function setResultText(?string $resultText): self
    {
        $this->resultText = $resultText;

        return $this;
    }

    public function getQuestionTheme(): ?QuestionTheme
    {
        return $this->questionTheme;
    }

    public function setQuestionTheme(?QuestionTheme $questionTheme): self
    {
        $this->questionTheme = $questionTheme;

        return $this;
    }

}
