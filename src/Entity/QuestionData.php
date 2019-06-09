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
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionTheme", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_id_theme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $result_text;

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

    public function getFkIdTheme(): ?QuestionTheme
    {
        return $this->fk_id_theme;
    }

    public function setFkIdTheme(QuestionTheme $fk_id_theme): self
    {
        $this->fk_id_theme = $fk_id_theme;

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
}
