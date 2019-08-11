<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\QuestionDataRepository")
 */
class QuestionData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $answers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $result_text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionTheme", inversedBy="questionData")
     * @ORM\JoinColumn(nullable=false)
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
        return $this->result_text;
    }

    public function setResultText(?string $result_text): self
    {
        $this->result_text = $result_text;

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
